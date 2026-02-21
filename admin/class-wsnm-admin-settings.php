<?php

/**
 * WSNM_Woo_Stock_Notify_Me_Admin_Settings
 */
class WSNM_Woo_Stock_Notify_Me_Admin_Settings
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
     * @param  mixed $helper
     * @return void
     */

    function __construct(WSNM_HELPER $helper)
    {
        $this->helper = $helper;
    }

    /**
     * enqueue_color_picker
     *
     * @param  mixed $hook_suffix
     * @return void
     */
    public function enqueue_color_picker($hook_suffix)
    {
        wp_enqueue_style('wp-color-picker');
    }

    /**
     * enqueue_preview_resources
     *
     * @param  mixed $hook_suffix
     * @return void
     */
    public function enqueue_preview_resources($hook_suffix)
    {
        if (isset($_GET['page']) && sanitize_text_field($_GET['page']) === 'wsnm-preview') {
            wp_enqueue_style(WSNM_DOMAIN . '-public', WSNM_URL . 'public/css/wsnm.css', array(), filemtime(WSNM_PATH . 'public/css/wsnm.css'));
            wp_enqueue_script(WSNM_DOMAIN . '-public', WSNM_URL . 'public/js/wsnm.js', array('jquery'), filemtime(WSNM_PATH . 'public/js/wsnm.js'));
            wp_localize_script(WSNM_DOMAIN . '-public', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
        }
    }

    /**
     * settings_menu
     *
     * @return void
     */
    public function settings_menu()
    {
        add_submenu_page(
            'edit.php?post_type=' . $this->helper->getCustomPostType(),
            __('Back in Stock - Settings', 'back-in-stock-notifications-for-woocommerce'),
            __('Settings', 'back-in-stock-notifications-for-woocommerce'),
            'manage_options',
            'wsnm-settings',
            array($this, 'settings_page_callback')
        );

        global $submenu;
        unset($submenu['edit.php?post_type=wsnm_notify_me'][10]);

        $parent = 'edit.php?post_type=wsnm_notify_me';
        $submenu[$parent][] = array(
            __('Subscription Form', 'back-in-stock-notifications-for-woocommerce'),
            'manage_options',
            admin_url('edit.php?post_type=wsnm_notify_me&page=wsnm-settings&tab=wsnm-settings-subscription-form'),
        );
        $submenu[$parent][] = array(
            __('Email Templates', 'back-in-stock-notifications-for-woocommerce'),
            'manage_options',
            admin_url('edit.php?post_type=wsnm_notify_me&page=wsnm-settings&tab=wsnm-settings-email-templates'),
        );
        $submenu[$parent][] = array(
            __('Integrations', 'back-in-stock-notifications-for-woocommerce'),
            'manage_options',
            admin_url('edit.php?post_type=wsnm_notify_me&page=wsnm-settings&tab=wsnm-settings-integrations'),
        );
    }

    /**
     * tinyMCE_theme_setup
     *
     * @return void
     */
    public function tinyMCE_theme_setup()
    {
        add_editor_style(array(plugins_url('css/editor-style.css', __FILE__)));
    }

    /**
     * settings_page_callback
     *
     * @return void
     */
    public function settings_page_callback()
    {
        if (!current_user_can('manage_options')) return;
        $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'wsnm-settings-general';
        $tabs = array(
            'wsnm-settings-general' => array(
                'title' => __('General', 'back-in-stock-notifications-for-woocommerce'),
                'url' => admin_url('edit.php?post_type=wsnm_notify_me&page=wsnm-settings'),
                'callback' => 'wsnm_settings_general_content'
            ),
            'wsnm-settings-subscription-form' => array(
                'title' => __('Subscription Form', 'back-in-stock-notifications-for-woocommerce'),
                'url' => admin_url('edit.php?post_type=wsnm_notify_me&page=wsnm-settings&tab=wsnm-settings-subscription-form'),
                'callback' => 'wsnm_settings_subscription_form_content'
            ),
            'wsnm-settings-email-templates' => array(
                'title' => __('Email Templates', 'back-in-stock-notifications-for-woocommerce'),
                'url' => admin_url('edit.php?post_type=wsnm_notify_me&page=wsnm-settings&tab=wsnm-settings-email-templates'),
                'callback' => 'wsnm_settings_email_templates_content'
            ),
            'wsnm-settings-integrations' => array(
                'title' => __('Integrations', 'back-in-stock-notifications-for-woocommerce'),
                'url' => admin_url('edit.php?post_type=wsnm_notify_me&page=wsnm-settings&tab=wsnm-settings-integrations'),
                'callback' => 'wsnm_settings_integrations_content'
            ),
            'wsnm-documentation' => array(
                'title' => __('Documentation', 'back-in-stock-notifications-for-woocommerce'),
                'url' => 'https://wordpress.org/plugins/back-in-stock-notifications-for-woocommerce/'
            ),
            'wsnm-support' => array(
                'title' => __('Support', 'back-in-stock-notifications-for-woocommerce'),
                'url' => 'https://wordpress.org/support/plugin/back-in-stock-notifications-for-woocommerce/'
            )
        );
        if ( ! array_key_exists( $active_tab, $tabs ) || ! isset( $tabs[$active_tab]['callback'] ) ) {
            $active_tab = 'wsnm-settings-general';
        }
        $callback = $tabs[$active_tab]['callback'];
        require_once WSNM_PATH . 'admin/parts/settings-page-header.php';
        $this->$callback();
        require_once WSNM_PATH . 'admin/parts/settings-page-footer.php';
    }

    /**
     * wsnm_settings_general_content
     *
     * @return void
     */
    public function wsnm_settings_general_content(): void
    {
        $colors         = $this->helper->get_button_colors();
        $mode           = $this->helper->get_mode();
        $button_display = $this->helper->get_button_display();
        require_once WSNM_PATH . 'admin/parts/page-general-settings.php';
    }

    /**
     * wsnm_settings_email_templates_content
     *
     * @return void
     */
    public function wsnm_settings_email_templates_content(): void
    {
        $subscribe_confirmation_email = $this->helper->getConfirmationEmailBody();
        $subscribe_confirmation_email_subject = $this->helper->getConfirmationEmailSubject();

        $subscribe_notification_email =  $this->helper->getNotificationEmailBody();
        $subscribe_notification_email_subject = $this->helper->getBackInStockNotificationEmailSubject();

        $subscribe_confirmation_email_status = get_option('wsnm_subscribe_confirmation_status');

        $tinymce_settings =  array(
            'toolbar1' => 'fontselect,fontsizeselect,separator,bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,forecolor,backcolor,separator,textcolor,link,undo,redo,separator,tags',
            'font_formats' => 'Sans Serif=arial,helvetica,sans-serif;Serif=times new roman, serif;Fixed Width=monospace, monospace;Wide=arial black, sans-serif;Narrow=arial narrow, sans-serif;Comic Sans MS=comic sans ms, sans-serif;Garamond=garamond, serif;Georgia=georgia, serif;Tahoma=tahoma, sans-serif;Trebuchet MS=trebuchet ms, sans-serif;Verdana=verdana, sans-serif;',
            'inline_styles' => false,
            'statusbar' => true
        );
        require_once WSNM_PATH . 'admin/parts/page-email-templates.php';
    }

    /**
     * wsnm_settings_subscription_form_content
     *
     * @return void
     */
    public function wsnm_settings_subscription_form_content(): void
    {
        $form_first_last_name = $this->helper->get_first_last_name_status();
        $before_form_text = $this->helper->get_pre_form_text();
        $after_form_text =  $this->helper->get_after_form_text();
        $button_text =  $this->helper->get_button_text();
        $modal_title =  $this->helper->get_modal_title();

        require_once WSNM_PATH . 'admin/parts/page-subscription-form.php';
    }

    /**
     * wsnm_settings_integrations_content
     *
     * @return void
     */
    public function wsnm_settings_integrations_content(): void
    {
        $recaptcha_status = get_option('wsnm_form_recaptcha_status') === 'enabled';
        $recaptcha_site_key = get_option('wsnm_recaptcha_site_key');
        $recaptcha_secret_key = get_option('wsnm_recaptcha_secret_key');
        require_once WSNM_PATH . 'admin/parts/page-integrations.php';
    }

    /**
     * preview_menu
     *
     * @return void
     */
    public function preview_menu()
    {
        add_submenu_page(
            null,
            __('Subscription Form Preview', 'back-in-stock-notifications-for-woocommerce'),
            __('Subscription Form Preview', 'back-in-stock-notifications-for-woocommerce'),
            'manage_options',
            'wsnm-preview',
            array($this, 'preview_page_callback')
        );
    }

    /**
     * preview_page_callback
     *
     * @return void
     */
    public function preview_page_callback()
    {
        if (!current_user_can('manage_options')) return;

        $button_text    = $this->helper->get_button_text();
        $colors         = $this->helper->get_button_colors();
        $name_status    = $this->helper->get_first_last_name_status();
        $before_form_text = $this->helper->get_pre_form_text();
        $after_form_text  = $this->helper->get_after_form_text();
        $recaptcha_key    = get_option('wsnm_recaptcha_site_key');
        $recaptcha_status = $this->helper->is_recaptcha_enabled();

        $preview_cta = sprintf(
            '<div id="wsnm-cta" class="wsnm-cta" style="background-color:%s; color:%s; cursor:pointer; display:inline-block;">%s</div>',
            esc_attr($colors['background']),
            esc_attr($colors['text']),
            esc_html(apply_filters('wsnm-text-cta', $button_text))
        );

        ob_start();
        require WSNM_PATH . 'public/parts/form-modal.php';
        $preview_modal = str_replace(
            '<div id="wsnm-modal" class="wsnm-modal">',
            '<div id="wsnm-modal" class="wsnm-modal" style="display:none;">',
            ob_get_clean()
        );

        $back_url = admin_url('edit.php?post_type=wsnm_notify_me&page=wsnm-settings&tab=wsnm-settings-subscription-form');

        require_once WSNM_PATH . 'admin/parts/page-preview.php';
    }

    /**
     * test_email_menu
     *
     * @return void
     */
    public function test_email_menu()
    {
        add_submenu_page(
            null,
            __('Send Test Email', 'back-in-stock-notifications-for-woocommerce'),
            __('Send Test Email', 'back-in-stock-notifications-for-woocommerce'),
            'manage_options',
            'wsnm-test-email',
            array($this, 'test_email_page_callback')
        );
    }

    /**
     * test_email_page_callback
     *
     * @return void
     */
    public function test_email_page_callback()
    {
        if (!current_user_can('manage_options')) return;

        $type = (isset($_GET['type']) && sanitize_key($_GET['type']) === 'notification') ? 'notification' : 'confirmation';

        $title = $type === 'confirmation'
            ? __('Test: Confirmation Email', 'back-in-stock-notifications-for-woocommerce')
            : __('Test: Back in Stock Email', 'back-in-stock-notifications-for-woocommerce');

        $default_email = wp_get_current_user()->user_email;
        $back_url      = admin_url('edit.php?post_type=wsnm_notify_me&page=wsnm-settings&tab=wsnm-settings-email-templates');
        $nonce         = wp_create_nonce('wsnm_test_email');

        require_once WSNM_PATH . 'admin/parts/page-test-email.php';
    }

    /**
     * enqueue_test_email_resources
     *
     * @param  mixed $hook_suffix
     * @return void
     */
    public function enqueue_test_email_resources($hook_suffix)
    {
        if (isset($_GET['page']) && sanitize_text_field($_GET['page']) === 'wsnm-test-email') {
            wp_enqueue_script('wc-enhanced-select');
            wp_enqueue_style('woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css', array(), WC_VERSION);
        }
    }

    /**
     * ajax_get_variations
     *
     * @return void
     */
    public function ajax_get_variations()
    {
        check_ajax_referer('wsnm_test_email', 'nonce');
        if (!current_user_can('manage_options')) wp_send_json_error();

        $product_id = intval($_POST['product_id']);
        $product    = wc_get_product($product_id);

        if (!$product || !$product->is_type('variable')) {
            wp_send_json_success(array());
            return;
        }

        $variations = array();
        foreach ($product->get_available_variations() as $v) {
            $obj = wc_get_product($v['variation_id']);
            if ($obj) {
                $variations[] = array(
                    'id'    => $v['variation_id'],
                    'label' => $obj->get_formatted_name(),
                );
            }
        }
        wp_send_json_success($variations);
    }

    /**
     * ajax_send_test_email
     *
     * @return void
     */
    public function ajax_send_test_email()
    {
        check_ajax_referer('wsnm_test_email', 'nonce');
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => __('Unauthorized.', 'back-in-stock-notifications-for-woocommerce')));
        }

        $type         = (isset($_POST['type']) && sanitize_key($_POST['type']) === 'notification') ? 'notification' : 'confirmation';
        $product_id   = intval($_POST['product_id']);
        $variation_id = !empty($_POST['variation_id']) ? intval($_POST['variation_id']) : 0;
        $email        = sanitize_email($_POST['email'] ?? '');

        if (!$product_id || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            wp_send_json_error(array('message' => __('Please select a product and enter a valid email address.', 'back-in-stock-notifications-for-woocommerce')));
        }

        $resolve_id = $variation_id ?: $product_id;
        if (!wc_get_product($resolve_id)) {
            wp_send_json_error(array('message' => __('Product not found.', 'back-in-stock-notifications-for-woocommerce')));
        }

        if ($type === 'confirmation') {
            $body    = nl2br($this->helper->getConfirmationEmailBody());
            $subject = $this->helper->getConfirmationEmailSubject();
        } else {
            $body    = nl2br($this->helper->getNotificationEmailBody());
            $subject = $this->helper->getBackInStockNotificationEmailSubject();
        }

        $body    = $this->helper->convert_product_merge_tags($body, $resolve_id);
        $subject = $this->helper->convert_product_merge_tags($subject, $resolve_id);

        $placeholders = array(
            '[wsnm-first-name]' => 'John',
            '[wsnm-last-name]'  => 'Doe',
            '[wsnm-email]'      => $email,
        );
        foreach ($placeholders as $tag => $value) {
            $body    = str_replace($tag, $value, $body);
            $subject = str_replace($tag, $value, $subject);
        }

        $headers = array('Content-Type: text/html; charset=UTF-8');
        $sent    = wp_mail($email, '[TEST] ' . $subject, $body, $headers);

        if ($sent) {
            wp_send_json_success(array('message' => sprintf(
                /* translators: %s: email address */
                __('Test email sent to %s', 'back-in-stock-notifications-for-woocommerce'),
                $email
            )));
        } else {
            wp_send_json_error(array('message' => __('Failed to send. Check your WordPress mail settings.', 'back-in-stock-notifications-for-woocommerce')));
        }
    }

    /**
     * save_settings
     *
     * @return void
     */
    public function save_settings()
    {
        //General Settings
        if (isset($_POST['nonce-wsnm-settings'])  && wp_verify_nonce($_POST['nonce-wsnm-settings'], 'wsnm-settings-save')) {
            //Mode 
            $mode = sanitize_text_field($_POST['wsnm_mode']);
            update_option('wsnm_mode', $mode);

            //Button Style
            $background_color = sanitize_hex_color($_POST['wsnm_btn_background_color']);
            $text_color = sanitize_hex_color($_POST['wsnm_btn_text_color']);
            update_option('wsnm_btn_background_color', $background_color);
            update_option('wsnm_btn_text_color', $text_color);

            //Button Display
            $allowed_display = [ 'both', 'single', 'shop', 'disabled' ];
            $button_display  = sanitize_key( $_POST['wsnm_button_display'] ?? 'both' );
            update_option( 'wsnm_button_display', in_array( $button_display, $allowed_display, true ) ? $button_display : 'both' );
        }

        //Email Template Settings
        if (isset($_POST['nonce-wsnm-email-settings'])  && wp_verify_nonce($_POST['nonce-wsnm-email-settings'], 'wsnm-email-settings-save')) {
            if(!isset($_POST['wsnm_reset_email'])){
                $confirmation_email = wp_kses(stripslashes_deep($_POST['wsnm_subscribe_confirmation']), wp_kses_allowed_html('post'));
                $confirmation_email_subject = sanitize_text_field($_POST['wsnm_subscribe_confirmation_subject']);
                update_option('wsnm_subscribe_confirmation_email', $confirmation_email);
                update_option('wsnm_subscribe_confirmation_email_subject', $confirmation_email_subject);
                if (isset($_POST['wsnm_subscribe_confirmation_status'])) {
                    update_option('wsnm_subscribe_confirmation_status', 'enabled');
                } else {
                    update_option('wsnm_subscribe_confirmation_status', 'disabled');
                }
                $notification_email = wp_kses(stripslashes_deep($_POST['wsnm_back_in_stock_notification']), wp_kses_allowed_html('post'));
                $notification_email_subject = sanitize_text_field($_POST['wsnm_back_in_stock_notification_subject']);
                update_option('wsnm_subscribe_notification_email', $notification_email);
                update_option('wsnm_subscribe_notification_email_subject', $notification_email_subject);
            }else{
                delete_option('wsnm_subscribe_confirmation_email');
                delete_option('wsnm_subscribe_confirmation_email_subject');
                delete_option('wsnm_subscribe_notification_email');
                delete_option('wsnm_subscribe_notification_email_subject');
                delete_option('wsnm_subscribe_confirmation_status');
            }
        }

        //Form Subscription Settings
        if (isset($_POST['nonce-wsnm-subscription-form-settings'])  && wp_verify_nonce($_POST['nonce-wsnm-subscription-form-settings'], 'wsnm-subscription-form-settings-save')) {
            //First & Last Name
            if (isset($_POST['wsnm_form_first_last_name'])) {
                update_option('wsnm_form_first_last_name', 'enabled');
            } else {
                update_option('wsnm_form_first_last_name', 'disabled');
            }

            //Button Text
            $button_text = sanitize_text_field($_POST['wsnm_button_text']);
            update_option('wsnm_btn_text', $button_text);

            //Modal Title
            $modal_title = sanitize_text_field($_POST['wsnm_modal_title']);
            update_option('wsnm_modal_title', $modal_title);

            //Before & Aftet text
            $before_text = wp_kses(stripslashes_deep($_POST['wsnm_pre_form_content']), wp_kses_allowed_html('post'));
            $after_text = wp_kses(stripslashes_deep($_POST['wsnm_after_form_content']), wp_kses_allowed_html('post'));
            update_option('wsnm_pre_form_content', stripslashes_deep($before_text));
            update_option('wsnm_after_form_content', stripslashes_deep($after_text));
        }

        //Integrations Settings
        if (isset($_POST['nonce-wsnm-integrations']) && wp_verify_nonce($_POST['nonce-wsnm-integrations'], 'wsnm-integrations-save')) {
            //reCAPTCHA
            update_option('wsnm_form_recaptcha_status', isset($_POST['wsnm_form_recaptcha_status']) ? 'enabled' : 'disabled');
            update_option('wsnm_recaptcha_site_key', sanitize_text_field($_POST['wsnm_recaptcha_site_key'] ?? ''));
            update_option('wsnm_recaptcha_secret_key', sanitize_text_field($_POST['wsnm_recaptcha_secret_key'] ?? ''));

            //HubSpot
            update_option('wsnm_hubspot_enabled', isset($_POST['wsnm_hubspot_enabled']) ? 'enabled' : 'disabled');
            update_option('wsnm_hubspot_token', sanitize_text_field($_POST['wsnm_hubspot_token']));
        }
    }

    /**
     * save_settings_notice
     *
     * @return void
     */
    public function save_settings_notice()
    {
        if (
            (isset($_POST['nonce-wsnm-settings'])  && wp_verify_nonce($_POST['nonce-wsnm-settings'], 'wsnm-settings-save'))
            ||
            (isset($_POST['nonce-wsnm-email-settings'])  && wp_verify_nonce($_POST['nonce-wsnm-email-settings'], 'wsnm-email-settings-save'))
            ||
            (isset($_POST['nonce-wsnm-subscription-form-settings'])  && wp_verify_nonce($_POST['nonce-wsnm-subscription-form-settings'], 'wsnm-subscription-form-settings-save'))
            ||
            (isset($_POST['nonce-wsnm-integrations']) && wp_verify_nonce($_POST['nonce-wsnm-integrations'], 'wsnm-integrations-save'))
        ) {
            echo sprintf(
                '<div class="notice notice-success is-dismissible"><p><strong>%s:</strong> %s</p></div>',
                WSNM_NAME,
                __('Settings successfully updated', 'back-in-stock-notifications-for-woocommerce')
            );
        }
    }
}
