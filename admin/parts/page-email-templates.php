<div class="wsnm-page-layout">
    <div class="wsnm-main">
        <form method="post">
            <div class="wsnm-settings-row">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
                    <h3 style="margin:0;">
                        <?php _e('Confirmation Email', 'back-in-stock-notifications-for-woocommerce'); ?>
                        <span class="dashicons dashicons-info-outline wsnm-tooltip">
                            <span class="wsnm-tooltip-text">
                                <?php _e('The confirmation email is sent when someone subscribes to get notifications.', 'back-in-stock-notifications-for-woocommerce'); ?>
                            </span>
                        </span>
                    </h3>
                    <a href="<?php echo esc_url(admin_url('admin.php?page=wsnm-test-email&type=confirmation')); ?>" class="button" style="margin-left:auto;display:inline-flex;align-items:center;">
                        <span class="dashicons dashicons-email-alt" style="font-size:14px;width:14px;height:14px;margin-right:4px;"></span>
                        <?php _e('Send Test Email', 'back-in-stock-notifications-for-woocommerce'); ?>
                    </a>
                </div>
                <div class="wsnm-field-row">
                    <label><input type="checkbox" name="wsnm_subscribe_confirmation_status" id="wsnm_subscribe_confirmation_status" <?php echo ($subscribe_confirmation_email_status == "disabled") ? "" : "checked"; ?>> <?php _e('Enable the confirmation email', 'back-in-stock-notifications-for-woocommerce'); ?></label>
                    <span class="dashicons dashicons-info-outline wsnm-tooltip">
                        <span class="wsnm-tooltip-text">
                            <?php _e('Uncheck to disable the default confirmation email.', 'back-in-stock-notifications-for-woocommerce'); ?>
                        </span>
                    </span>
                </div>
                <div class="wsnm-field-row" id="wsnm_subscribe_confirmation_row" style="display: <?php echo ($subscribe_confirmation_email_status == "disabled") ? "none" : "block"; ?> ">
                    <div class="wsnm-field-sub-row">
                        <label for="wsnm_subscribe_confirmation_subject">
                            <p><?php _e('Confirmation Email - Subject', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                        </label>
                        <input type="text" value="<?php echo wp_kses($subscribe_confirmation_email_subject, array()); ?>" id="wsnm_subscribe_confirmation_subject" name="wsnm_subscribe_confirmation_subject">
                    </div>
                    <div class="wsnm-field-sub-row">
                        <label for="wsnm_subscribe_confirmation">
                            <p><?php _e('Confirmation Email - Content', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                        </label>
                        <?php
                        $tinymce_settings['setup'] = 'function (editor) {
                                    editor.addButton("tags", {
                                        type: "listbox",
                                        text: "Merge Tags",
                                        icon: false,
                                        onselect: function (e) {
                                            editor.insertContent(this.value());
                                        },
                                        values: [
                                            { text: "First Name", value: "[wsnm-first-name]" },
                                            { text: "Last Name", value: "[wsnm-last-name]" },
                                            { text: "Email", value: "[wsnm-email]" },
                                            { text: "Product Title", value: "[wsnm-product-title]" },
                                            { text: "Product Price", value: "[wsnm-product-price]" },
                                            { text: "Product URL", value: "[wsnm-product-url]" },
                                        ]
                                    });
                                }';
                        $settings = array('tinymce' => $tinymce_settings, 'theme' => 'modern', 'plugins' => 'textcolor, link, autolink, linkchecker', 'media_buttons' => false, 'quicktags' => false,  'textarea_rows' =>  12, 'textarea_name' => 'wsnm_subscribe_confirmation', 'wpautop' => true);
                        wp_editor($subscribe_confirmation_email, 'wsnm_subscribe_confirmation', $settings);
                        ?>
                    </div>
                </div>
            </div>
            <div class="wsnm-settings-row">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
                    <h3 style="margin:0;">
                        <?php _e('Back in Stock Notification Email', 'back-in-stock-notifications-for-woocommerce'); ?>
                        <span class="dashicons dashicons-info-outline wsnm-tooltip">
                            <span class="wsnm-tooltip-text">
                                <?php _e('The back in stock notification email is sent when the product is back in stock again.', 'back-in-stock-notifications-for-woocommerce'); ?>
                            </span>
                        </span>
                    </h3>
                    <a href="<?php echo esc_url(admin_url('admin.php?page=wsnm-test-email&type=notification')); ?>" class="button" style="margin-left:auto;display:inline-flex;align-items:center;">
                        <span class="dashicons dashicons-email-alt" style="font-size:14px;width:14px;height:14px;margin-right:4px;"></span>
                        <?php _e('Send Test Email', 'back-in-stock-notifications-for-woocommerce'); ?>
                    </a>
                </div>
                <div class="wsnm-field-row">
                    <div class="wsnm-field-sub-row">
                        <label for="wsnm_back_in_stock_notification_subject">
                            <p><?php _e('Back in Stock Notification Email - Subject', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                        </label>
                        <input type="text" value="<?php echo wp_kses($subscribe_notification_email_subject, array()); ?>" id="wsnm_back_in_stock_notification_subject" name="wsnm_back_in_stock_notification_subject">
                    </div>
                    <div class="wsnm-field-sub-row">
                        <label for="wsnm_back_in_stock_notification">
                            <p><?php _e('Back in Stock Notification Email - Content', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                        </label>
                        <?php
                        $tinymce_settings['setup'] = 'function (editor) {
                                    editor.addButton("tags", {
                                        type: "listbox",
                                        text: "Merge Tags",
                                        icon: false,
                                        onselect: function (e) {
                                            editor.insertContent(this.value());
                                        },
                                        values: [
                                            { text: "First Name", value: "[wsnm-first-name]" },
                                            { text: "Last Name", value: "[wsnm-last-name]" },
                                            { text: "Email", value: "[wsnm-email]" },
                                            { text: "Product Title", value: "[wsnm-product-title]" },
                                            { text: "Product Price", value: "[wsnm-product-price]" },
                                            { text: "Product Quantity", value: "[wsnm-product-quantity]" },
                                            { text: "Product URL", value: "[wsnm-product-url]" },
                                        ]
                                    });
                                }';
                        $settings = array('tinymce' => $tinymce_settings, 'theme' => 'modern', 'plugins' => 'textcolor, link, autolink, linkchecker', 'media_buttons' => false, 'quicktags' => false,  'textarea_rows' =>  12, 'textarea_name' => 'wsnm_back_in_stock_notification', 'wpautop' => true);
                        wp_editor($subscribe_notification_email, 'wsnm_back_in_stock_notification', $settings);
                        ?>
                    </div>
                </div>
                <div class="wsnm-field-row">
                    <label><input type="checkbox" name="wsnm_reset_email" id="wsnm_reset_email"> <?php _e('Reset both emails - The confirmation and Back in stock notification', 'back-in-stock-notifications-for-woocommerce'); ?></label>
                </div>
            </div>
            <?php wp_nonce_field('wsnm-email-settings-save', 'nonce-wsnm-email-settings'); ?>
            <input type="submit" class="button" value="<?php _e('Save', 'back-in-stock-notifications-for-woocommerce'); ?>">
        </form>
    </div><!-- /.wsnm-main -->

    <aside class="wsnm-sidebar">
        <div class="wsnm-help-box">
            <h4><?php _e('Confirmation Email', 'back-in-stock-notifications-for-woocommerce'); ?></h4>
            <p><?php _e('Sent immediately after someone subscribes. Use it to reassure subscribers that they\'re on the list. Keep it short and friendly.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
            <p><?php _e('You can disable it entirely if you prefer a silent opt-in.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
        </div>
        <div class="wsnm-help-box">
            <h4><?php _e('Notification Email', 'back-in-stock-notifications-for-woocommerce'); ?></h4>
            <p><?php _e('Sent when a product comes back in stock (automatically) or when you trigger it manually from the product page. Always include a link to the product so subscribers can buy immediately.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
        </div>
        <div class="wsnm-help-box">
            <h4><?php _e('Available Merge Tags', 'back-in-stock-notifications-for-woocommerce'); ?></h4>
            <p><?php _e('Use these tags in subject lines and email bodies:', 'back-in-stock-notifications-for-woocommerce'); ?></p>
            <ul>
                <li><code>[wsnm-first-name]</code> — <?php _e('Subscriber\'s first name', 'back-in-stock-notifications-for-woocommerce'); ?></li>
                <li><code>[wsnm-last-name]</code> — <?php _e('Subscriber\'s last name', 'back-in-stock-notifications-for-woocommerce'); ?></li>
                <li><code>[wsnm-email]</code> — <?php _e('Subscriber\'s email address', 'back-in-stock-notifications-for-woocommerce'); ?></li>
                <li><code>[wsnm-product-title]</code> — <?php _e('Product name (including variation)', 'back-in-stock-notifications-for-woocommerce'); ?></li>
                <li><code>[wsnm-product-price]</code> — <?php _e('Product price with currency', 'back-in-stock-notifications-for-woocommerce'); ?></li>
                <li><code>[wsnm-product-quantity]</code> — <?php _e('Available quantity, or "unlimited"', 'back-in-stock-notifications-for-woocommerce'); ?></li>
                <li><code>[wsnm-product-url]</code> — <?php _e('Direct link to the product (variation pre-selected)', 'back-in-stock-notifications-for-woocommerce'); ?></li>
            </ul>
        </div>
        <div class="wsnm-help-box">
            <h4><?php _e('Reset Emails', 'back-in-stock-notifications-for-woocommerce'); ?></h4>
            <p><?php _e('Checking "Reset both emails" and saving will discard all customisations and restore the plugin\'s default email content. This cannot be undone.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
        </div>
    </aside>
</div><!-- /.wsnm-page-layout -->
