<div class="wsnm-page-layout">
    <div class="wsnm-main">
        <form method="post">

            <div class="wsnm-settings-row">
                <h3><?php _e('reCAPTCHA v2', 'back-in-stock-notifications-for-woocommerce'); ?></h3>

                <div class="wsnm-field-row">
                    <div class="wsnm-field-sub-row">
                        <label>
                            <input type="checkbox" id="wsnm_form_recaptcha_status" name="wsnm_form_recaptcha_status" <?php echo ($recaptcha_status) ? 'checked' : ''; ?> />
                            <?php _e('Enable reCAPTCHA v2', 'back-in-stock-notifications-for-woocommerce'); ?>
                        </label>
                        <p class="description"><?php _e('Avoid spam by enabling reCAPTCHA v2. <a href="https://www.google.com/recaptcha" target="_blank">Generate your Site &amp; Secret keys here</a>.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                    </div>
                </div>

                <div class="wsnm-field-row" id="wsnm_form_recaptcha" style="display: <?php echo ($recaptcha_status) ? 'block' : 'none'; ?>">
                    <div class="wsnm-field-sub-row">
                        <label for="wsnm_recaptcha_site_key">
                            <p><?php _e('Site Key', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                        </label>
                        <input type="text" value="<?php echo esc_attr($recaptcha_site_key); ?>" id="wsnm_recaptcha_site_key" name="wsnm_recaptcha_site_key" />
                    </div>
                    <div class="wsnm-field-sub-row">
                        <label for="wsnm_recaptcha_secret_key">
                            <p><?php _e('Secret Key', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                        </label>
                        <input type="text" value="<?php echo esc_attr($recaptcha_secret_key); ?>" id="wsnm_recaptcha_secret_key" name="wsnm_recaptcha_secret_key" />
                    </div>
                </div>
            </div>

            <div class="wsnm-settings-row">
                <h3><?php _e('HubSpot', 'back-in-stock-notifications-for-woocommerce'); ?></h3>

                <div class="wsnm-field-row">
                    <div class="wsnm-field-sub-row">
                        <label for="wsnm_hubspot_enabled">
                            <input type="checkbox" id="wsnm_hubspot_enabled" name="wsnm_hubspot_enabled" <?php checked(get_option('wsnm_hubspot_enabled'), 'enabled'); ?> />
                            <?php _e('Enable HubSpot integration', 'back-in-stock-notifications-for-woocommerce'); ?>
                        </label>
                        <p class="description"><?php _e('When enabled, each new subscription will create or update a contact in HubSpot.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                    </div>
                </div>

                <div class="wsnm-field-row">
                    <div class="wsnm-field-sub-row">
                        <label for="wsnm_hubspot_token">
                            <p><?php _e('Private App Token', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                        </label>
                        <input type="text" id="wsnm_hubspot_token" name="wsnm_hubspot_token" value="<?php echo esc_attr(get_option('wsnm_hubspot_token')); ?>" placeholder="pat-na1-..." />
                        <p class="description">
                            <?php _e('Go to HubSpot → Settings → Integrations → Private Apps and create an app with the <strong>crm.objects.contacts.write</strong> scope. Paste the generated token above.', 'back-in-stock-notifications-for-woocommerce'); ?>
                        </p>
                    </div>
                </div>
            </div>

            <?php wp_nonce_field('wsnm-integrations-save', 'nonce-wsnm-integrations'); ?>
            <input type="submit" class="button button-primary" value="<?php _e('Save', 'back-in-stock-notifications-for-woocommerce'); ?>" />
            <button type="button" id="wsnm-hubspot-check" class="button"><?php _e('Check connection', 'back-in-stock-notifications-for-woocommerce'); ?></button>
            <span id="wsnm-hubspot-check-result" style="display:none;margin-left:10px;"></span>

        </form>
    </div><!-- /.wsnm-main -->

    <aside class="wsnm-sidebar">
        <div class="wsnm-help-box">
            <h4><?php _e('reCAPTCHA v2', 'back-in-stock-notifications-for-woocommerce'); ?></h4>
            <p><?php _e('Adds a "I\'m not a robot" checkbox to the subscribe form, blocking automated spam submissions. Requires a free Google reCAPTCHA v2 account.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
            <p><?php _e('<strong>Site Key</strong> — used in the frontend widget (public).<br><strong>Secret Key</strong> — used server-side to verify the response. Keep it private.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
        </div>
        <div class="wsnm-help-box">
            <h4><?php _e('HubSpot', 'back-in-stock-notifications-for-woocommerce'); ?></h4>
            <p><?php _e('When enabled, every new subscription automatically creates or updates a contact in your HubSpot CRM (matched by email address — no duplicates) and attaches a note with the subscribed product name.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
            <p><?php _e('The sync result (contact link or error) is visible on each subscription\'s detail page in the WordPress admin.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
            <p><strong><?php _e('How to get a token:', 'back-in-stock-notifications-for-woocommerce'); ?></strong></p>
            <ol>
                <li><?php _e('In HubSpot, go to <strong>Settings → Integrations → Private Apps</strong>.', 'back-in-stock-notifications-for-woocommerce'); ?></li>
                <li><?php _e('Create a new app and enable the <code>crm.objects.contacts.write</code> scope.', 'back-in-stock-notifications-for-woocommerce'); ?></li>
                <li><?php _e('Copy the generated token (starts with <code>pat-</code>) and paste it above.', 'back-in-stock-notifications-for-woocommerce'); ?></li>
                <li><?php _e('Click <strong>Check connection</strong> to verify the token is valid.', 'back-in-stock-notifications-for-woocommerce'); ?></li>
            </ol>
        </div>
    </aside>
</div><!-- /.wsnm-page-layout -->
