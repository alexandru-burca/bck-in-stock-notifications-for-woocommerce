<div class="wrap">
    <!-- <h2></h2> to display notices under it -->
    <h2></h2>
    <nav class="wsnm-tab-wrapper">
        <img src="<?php echo WSNM_URL . 'admin/img/logo.jpg'; ?>" alt="<?php _e('Back in Stock', 'back-in-stock-notifications-for-woocommerce'); ?>" class="wsnm-settings-logo">
        <span style="font-weight:600; color:#1d2327; font-size:14px;">
            <?php echo esc_html($title); ?>
        </span>
        <a href="<?php echo esc_url($back_url); ?>" class="button" style="margin-left:auto;">
            &larr; <?php _e('Back to Settings', 'back-in-stock-notifications-for-woocommerce'); ?>
        </a>
    </nav>

    <div class="wsnm-content">
        <div class="wsnm-page-layout">

            <div class="wsnm-main">
                <div class="wsnm-settings-row">

                    <div class="wsnm-field-row">
                        <div class="wsnm-field-sub-row">
                            <label for="wsnm_test_product_id">
                                <p><?php _e('Product', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                            </label>
                            <select id="wsnm_test_product_id" class="wc-product-search" style="width:100%;"
                                data-placeholder="<?php esc_attr_e('Search for a product&hellip;', 'back-in-stock-notifications-for-woocommerce'); ?>"
                                data-allow_clear="true">
                            </select>
                        </div>
                    </div>

                    <div class="wsnm-field-row" id="wsnm-variation-row" style="display:none;">
                        <div class="wsnm-field-sub-row">
                            <label for="wsnm_test_variation_id">
                                <p><?php _e('Variation', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                            </label>
                            <select id="wsnm_test_variation_id" style="width:100%;">
                                <option value=""><?php _e('Select a variation (optional)', 'back-in-stock-notifications-for-woocommerce'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="wsnm-field-row">
                        <div class="wsnm-field-sub-row">
                            <label for="wsnm_test_email_address">
                                <p><?php _e('Send to', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                            </label>
                            <input type="email" id="wsnm_test_email_address" value="<?php echo esc_attr($default_email); ?>" style="width:100%;" />
                        </div>
                    </div>

                    <div class="wsnm-field-row">
                        <button type="button" id="wsnm-send-test" class="button button-primary" style="display:inline-flex;align-items:center;">
                            <span class="dashicons dashicons-email-alt" style="font-size:14px;width:14px;height:14px;margin-right:4px;"></span>
                            <?php _e('Send Test Email', 'back-in-stock-notifications-for-woocommerce'); ?>
                        </button>
                        <span id="wsnm-test-result" style="margin-left:12px; line-height:28px; font-size:13px;"></span>
                    </div>

                </div>
            </div>

            <aside class="wsnm-sidebar">
                <div class="wsnm-help-box">
                    <h4><?php _e('What this does', 'back-in-stock-notifications-for-woocommerce'); ?></h4>
                    <p><?php _e('Sends a real email using your saved template and subject line, with merge tags replaced by actual product data from the product you select.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                    <p><?php _e('The subject line is prefixed with <code>[TEST]</code> so you can tell it apart from live emails.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                </div>
                <div class="wsnm-help-box">
                    <h4><?php _e('Subscriber placeholders', 'back-in-stock-notifications-for-woocommerce'); ?></h4>
                    <p><?php _e('Since there is no real subscriber, these merge tags are substituted with sample values:', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                    <ul>
                        <li><code>[wsnm-first-name]</code> &rarr; John</li>
                        <li><code>[wsnm-last-name]</code> &rarr; Doe</li>
                        <li><code>[wsnm-email]</code> &rarr; <?php _e('the address you enter above', 'back-in-stock-notifications-for-woocommerce'); ?></li>
                    </ul>
                </div>
                <div class="wsnm-help-box">
                    <h4><?php _e('Not receiving the email?', 'back-in-stock-notifications-for-woocommerce'); ?></h4>
                    <p><?php _e('WordPress uses <code>wp_mail()</code> which relies on your server\'s mail setup. If emails don\'t arrive, use an SMTP plugin (e.g. WP Mail SMTP) to ensure reliable delivery.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                </div>
            </aside>

        </div><!-- /.wsnm-page-layout -->
    </div><!-- /.wsnm-content -->
</div><!-- /.wrap -->

<script>
jQuery(document).ready(function($) {

    var nonce = '<?php echo esc_js($nonce); ?>';
    var type  = '<?php echo esc_js($type); ?>';

    // When product changes, fetch its variations
    $(document).on('change', '#wsnm_test_product_id', function() {
        var productId = $(this).val();
        var $variationRow    = $('#wsnm-variation-row');
        var $variationSelect = $('#wsnm_test_variation_id');

        $variationRow.hide();
        $variationSelect.find('option:not(:first)').remove();

        if (!productId) return;

        $.post(ajaxurl, {
            action:     'wsnm_get_variations',
            product_id: productId,
            nonce:      nonce
        }, function(response) {
            if (response.success && response.data.length > 0) {
                $.each(response.data, function(i, v) {
                    $variationSelect.append('<option value="' + v.id + '">' + $('<div>').text(v.label).html() + '</option>');
                });
                $variationRow.show();
            }
        });
    });

    // Send test email
    $('#wsnm-send-test').on('click', function() {
        var $btn      = $(this);
        var $result   = $('#wsnm-test-result');
        var productId = $('#wsnm_test_product_id').val();
        var varId     = $('#wsnm_test_variation_id').val() || '';
        var email     = $('#wsnm_test_email_address').val();

        $result.html('');

        if (!productId || !email) {
            $result.html('<span style="color:#cc1818;"><?php echo esc_js(__('Please select a product and enter an email address.', 'back-in-stock-notifications-for-woocommerce')); ?></span>');
            return;
        }

        $btn.prop('disabled', true).find('.dashicons').after(' <?php echo esc_js(__('Sending…', 'back-in-stock-notifications-for-woocommerce')); ?>');

        $.post(ajaxurl, {
            action:       'wsnm_send_test_email',
            type:         type,
            product_id:   productId,
            variation_id: varId,
            email:        email,
            nonce:        nonce
        }, function(response) {
            $btn.prop('disabled', false).html(
                '<span class="dashicons dashicons-email-alt" style="font-size:14px;width:14px;height:14px;margin-right:4px;"></span><?php echo esc_js(__('Send Test Email', 'back-in-stock-notifications-for-woocommerce')); ?>'
            );
            if (response.success) {
                $result.html('<span style="color:#46b450;">&#10003; ' + response.data.message + '</span>');
            } else {
                $result.html('<span style="color:#cc1818;">&#10007; ' + response.data.message + '</span>');
            }
        });
    });

});
</script>
