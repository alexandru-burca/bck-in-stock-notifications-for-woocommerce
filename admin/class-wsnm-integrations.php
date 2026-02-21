<?php

/**
 * WSNM_Integrations
 *
 * Handles all third-party integration logic (HubSpot, etc.).
 * Keeps integration code isolated from the core public and admin classes.
 */
class WSNM_Integrations
{

    /**
     * helper
     *
     * @var WSNM_HELPER
     */
    public $helper;

    /**
     * __construct
     *
     * @param  WSNM_HELPER $helper
     */
    public function __construct( WSNM_HELPER $helper )
    {
        $this->helper = $helper;
    }

    // -----------------------------------------------------------------------
    // Admin: enqueue
    // -----------------------------------------------------------------------

    /**
     * enqueue_admin_scripts
     *
     * Localizes the JS nonce for the check-connection button.
     *
     * @return void
     */
    public function enqueue_admin_scripts(): void
    {
        wp_localize_script( WSNM_DOMAIN, 'wsnm_admin', array(
            'hubspot_check_nonce' => wp_create_nonce( 'wsnm-hubspot-check' ),
        ) );
    }

    // -----------------------------------------------------------------------
    // Admin: AJAX — check HubSpot connection
    // -----------------------------------------------------------------------

    /**
     * check_hubspot_connection
     *
     * AJAX handler for the "Check connection" button on the Integrations tab.
     * Validates the token against the HubSpot account-info API and caches the
     * portal ID so contact links can be constructed in the details box.
     *
     * @return void
     */
    public function check_hubspot_connection(): void
    {
        check_ajax_referer( 'wsnm-hubspot-check', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) wp_send_json_error();

        $token = sanitize_text_field( $_POST['token'] ?? '' );
        if ( empty( $token ) ) {
            wp_send_json_error( array( 'message' => __( 'Please enter a token first.', 'back-in-stock-notifications-for-woocommerce' ) ) );
        }

        $response = wp_remote_get( 'https://api.hubapi.com/account-info/v3/details', array(
            'timeout' => 5,
            'headers' => array( 'Authorization' => 'Bearer ' . $token ),
        ) );

        if ( is_wp_error( $response ) ) {
            wp_send_json_error( array( 'message' => $response->get_error_message() ) );
        }

        $status = wp_remote_retrieve_response_code( $response );
        $body   = json_decode( wp_remote_retrieve_body( $response ), true );

        if ( $status === 200 ) {
            $portal_id = $body['portalId'] ?? null;
            if ( $portal_id ) {
                update_option( 'wsnm_hubspot_portal_id', $portal_id );
            }
            wp_send_json_success( array(
                'message' => sprintf(
                    __( 'Connected! Portal ID: %s', 'back-in-stock-notifications-for-woocommerce' ),
                    esc_html( (string) $portal_id )
                ),
            ) );
        } else {
            wp_send_json_error( array(
                'message' => $body['message'] ?? __( 'Connection failed. Check your token.', 'back-in-stock-notifications-for-woocommerce' ),
            ) );
        }
    }

    // -----------------------------------------------------------------------
    // Public: push subscription to HubSpot
    // -----------------------------------------------------------------------

    /**
     * push_to_hubspot
     *
     * Creates or finds a HubSpot contact for a new subscription, attaches a
     * note with the subscribed product, and stores the result in post meta.
     *
     * @param  array $meta    Subscription meta saved to the post.
     * @param  int   $post_id The subscription post ID.
     * @return void
     */
    public function push_to_hubspot( array $meta, int $post_id ): void
    {
        if ( get_option( 'wsnm_hubspot_enabled' ) !== 'enabled' ) return;
        $token = get_option( 'wsnm_hubspot_token', '' );
        if ( empty( $token ) ) return;

        $headers = array(
            'Authorization' => 'Bearer ' . $token,
            'Content-Type'  => 'application/json',
        );

        // Build contact properties.
        $properties = array( 'email' => $meta['wsnm_email'] );
        if ( ! empty( $meta['wsnm_first_name'] ) ) $properties['firstname'] = $meta['wsnm_first_name'];
        if ( ! empty( $meta['wsnm_last_name'] ) )  $properties['lastname']  = $meta['wsnm_last_name'];

        $response = wp_remote_post( 'https://api.hubapi.com/crm/v3/objects/contacts', array(
            'timeout' => 5,
            'headers' => $headers,
            'body'    => wp_json_encode( array( 'properties' => $properties ) ),
        ) );

        if ( is_wp_error( $response ) ) {
            update_post_meta( $post_id, 'wsnm_hubspot_error', $response->get_error_message() );
            return;
        }

        $status_code = wp_remote_retrieve_response_code( $response );
        $body        = json_decode( wp_remote_retrieve_body( $response ), true );
        $contact_id  = null;

        if ( $status_code === 201 ) {
            $contact_id = $body['id'] ?? null;
        } elseif ( $status_code === 409 ) {
            // Contact already exists. Try to get the ID without an extra API call:
            // 1. from the `id` field (some API versions include it), or
            // 2. by parsing "Existing ID: 12345" from the message string.
            // Fall back to a search only if both are unavailable.
            if ( ! empty( $body['id'] ) ) {
                $contact_id = $body['id'];
            } elseif ( isset( $body['message'] ) && preg_match( '/Existing ID:\s*(\d+)/i', $body['message'], $m ) ) {
                $contact_id = $m[1];
            } else {
                $contact_id = $this->search_hubspot_contact( $meta['wsnm_email'], $headers );
            }
        }

        if ( ! $contact_id ) {
            $error = $body['message'] ?? __( 'Unknown error', 'back-in-stock-notifications-for-woocommerce' );
            update_post_meta( $post_id, 'wsnm_hubspot_error', $error );
            return;
        }

        // Resolve product name for the note.
        $product_label = '';
        $wc_product    = wc_get_product( $meta['wsnm_product_id'] ?? 0 );
        if ( $wc_product ) {
            $product_label = $wc_product->get_name();
            if ( ! empty( $meta['wsnm_variation_id'] ) ) {
                $variation = wc_get_product( $meta['wsnm_variation_id'] );
                if ( $variation ) {
                    $summary = $variation->get_attribute_summary();
                    $product_label .= ' – ' . ( $summary !== '' ? $summary : $variation->get_name() );
                }
            }
        }

        if ( $product_label ) {
            $this->create_hubspot_note( $headers, $contact_id, $product_label );
        }

        // Persist result.
        update_post_meta( $post_id, 'wsnm_hubspot_contact_id', $contact_id );
        update_post_meta( $post_id, 'wsnm_hubspot_synced_at', current_time( 'mysql' ) );
        delete_post_meta( $post_id, 'wsnm_hubspot_error' );
    }

    // -----------------------------------------------------------------------
    // Private helpers
    // -----------------------------------------------------------------------

    /**
     * search_hubspot_contact
     *
     * Finds a HubSpot contact by email and returns its ID.
     *
     * @param  string $email
     * @param  array  $headers
     * @return string|null
     */
    private function search_hubspot_contact( string $email, array $headers ): ?string
    {
        $response = wp_remote_post( 'https://api.hubapi.com/crm/v3/objects/contacts/search', array(
            'timeout' => 5,
            'headers' => $headers,
            'body'    => wp_json_encode( array(
                'filterGroups' => array( array(
                    'filters' => array( array(
                        'propertyName' => 'email',
                        'operator'     => 'EQ',
                        'value'        => $email,
                    ) ),
                ) ),
                'properties' => array( 'email' ),
                'limit'      => 1,
            ) ),
        ) );

        if ( is_wp_error( $response ) ) return null;
        $body = json_decode( wp_remote_retrieve_body( $response ), true );
        return $body['results'][0]['id'] ?? null;
    }

    /**
     * create_hubspot_note
     *
     * Creates a HubSpot note associated with a contact.
     *
     * @param  array  $headers
     * @param  string $contact_id
     * @param  string $product_label
     * @return void
     */
    private function create_hubspot_note( array $headers, string $contact_id, string $product_label ): void
    {
        wp_remote_post( 'https://api.hubapi.com/crm/v3/objects/notes', array(
            'timeout' => 5,
            'headers' => $headers,
            'body'    => wp_json_encode( array(
                'properties'   => array(
                    'hs_timestamp' => (string) ( time() * 1000 ),
                    'hs_note_body' => sprintf(
                        __( 'Back In Stock subscription: %s', 'back-in-stock-notifications-for-woocommerce' ),
                        esc_html( $product_label )
                    ),
                ),
                'associations' => array( array(
                    'to'    => array( 'id' => $contact_id ),
                    'types' => array( array(
                        'associationCategory' => 'HUBSPOT_DEFINED',
                        'associationTypeId'   => 202,
                    ) ),
                ) ),
            ) ),
        ) );
    }
}
