<div class="wsnm-page-layout">
    <div class="wsnm-main">
        <form method="post">
            <div class="wsnm-settings-row">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
                    <h3 style="margin:0;">
                        <?php _e('Form Settings', 'back-in-stock-notifications-for-woocommerce'); ?>
                        <span class="dashicons dashicons-info-outline wsnm-tooltip">
                            <span class="wsnm-tooltip-text">
                                <?php _e('Manage the subscription form', 'back-in-stock-notifications-for-woocommerce'); ?>
                            </span>
                        </span>
                    </h3>
                    <a href="<?php echo esc_url(admin_url('admin.php?page=wsnm-preview')); ?>" class="button" style="margin-left:auto;display:inline-flex;align-items:center;">
                        <span class="dashicons dashicons-visibility" style="font-size:14px;width:14px;height:14px;margin-right:4px;"></span>
                        <?php _e('Preview', 'back-in-stock-notifications-for-woocommerce'); ?>
                    </a>
                </div>
                <div class="wsnm-field-row">
                    <div class="wsnm-field-sub-row">
                        <label><input type="checkbox" id="wsnm_form_first_last_name" name="wsnm_form_first_last_name" <?php echo ($form_first_last_name) ? "checked" : ""; ?>><?php _e('Enable First and Last Name', 'back-in-stock-notifications-for-woocommerce'); ?></label>
                    </div>
                </div>
            </div>
            <div class="wsnm-settings-row">
                <h3>
                    <?php _e('Other Settings', 'back-in-stock-notifications-for-woocommerce'); ?>
                </h3>
                <div class="wsnm-field-row">
                    <div class="wsnm-field-sub-row">
                        <label for="wsnm_button_text">
                            <p><?php _e('Button Text', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                        </label>
                        <input type="text" value="<?php echo esc_html($button_text); ?>" id="wsnm_button_text" name="wsnm_button_text" required>
                    </div>
                </div>
                <div class="wsnm-field-row">
                    <div class="wsnm-field-sub-row">
                        <label for="wsnm_modal_title">
                            <p><?php _e('Modal Title', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                        </label>
                        <input type="text" value="<?php echo esc_html($modal_title); ?>" id="wsnm_modal_title" name="wsnm_modal_title" required>
                    </div>
                </div>
                <div class="wsnm-field-row">
                    <div class="wsnm-field-sub-row">
                        <label for="wsnm_pre_form_content">
                            <p><?php _e('Before Form Text', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                        </label>
                        <?php
                        $tinymce_settings = array(
                            'toolbar1'      => 'fontselect, fontsizeselect, separator, bold, italic, underline, separator, alignleft, aligncenter, alignright, separator, forecolor, backcolor, separator, textcolor, link, undo, redo, separator, removeformat, tags',
                            'font_formats' => 'Sans Serif=arial,helvetica,sans-serif;Serif=times new roman, serif;Fixed Width=monospace, monospace;Wide=arial black, sans-serif;Narrow=arial narrow, sans-serif;Comic Sans MS=comic sans ms, sans-serif;Garamond=garamond, serif;Georgia=georgia, serif;Tahoma=tahoma, sans-serif;Trebuchet MS=trebuchet ms, sans-serif;Verdana=verdana, sans-serif;',
                            'inline_styles' => false,
                            'statusbar' => false,
                        );
                        $tinymce_settings['setup'] = 'function (editor) {
                                    editor.addButton("tags", {
                                        type: "listbox",
                                        text: "Merge Tags",
                                        icon: false,
                                        onselect: function (e) {
                                            editor.insertContent(this.value());
                                        },
                                        values: [
                                            { text: "Product Title", value: "[wsnm-product-title]" },
                                            { text: "Product Price", value: "[wsnm-product-price]" }
                                        ]
                                    });
                                }';
                        $settings = array('tinymce' => $tinymce_settings, 'theme' => 'modern', 'plugins' => 'textcolor, link, autolink, linkchecker', 'media_buttons' => false, 'quicktags' => false, 'textarea_rows' => 10, 'menubar' => 'insert', 'wpautop' => true, 'textarea_name' => 'wsnm_pre_form_content');
                        wp_editor($before_form_text, 'wsnm_pre_form_content', $settings);
                        ?>
                    </div>
                    <div class="wsnm-field-sub-row">
                        <label for="wsnm_after_form_content">
                            <p><?php _e('After Form Text', 'back-in-stock-notifications-for-woocommerce'); ?></p>
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
                                                { text: "Product Title", value: "[wsnm-product-title]" },
                                                { text: "Product Price", value: "[wsnm-product-price]" }
                                            ]
                                        });
                                    }';
                        $settings = array('tinymce' => $tinymce_settings, 'theme' => 'modern', 'plugins' => 'textcolor, link, autolink, linkchecker', 'media_buttons' => false, 'quicktags' => false, 'textarea_rows' => 10, 'menubar' => 'insert', 'wpautop' => true, 'textarea_name' => 'wsnm_after_form_content');
                        wp_editor($after_form_text, 'wsnm_after_form_content', $settings);
                        ?>
                    </div>
                </div>
            </div>
            <?php wp_nonce_field('wsnm-subscription-form-settings-save', 'nonce-wsnm-subscription-form-settings'); ?>
            <input type="submit" class="button" value="<?php _e('Save', 'back-in-stock-notifications-for-woocommerce'); ?>">
        </form>
    </div><!-- /.wsnm-main -->

    <aside class="wsnm-sidebar">
        <div class="wsnm-help-box">
            <h4><?php _e('First &amp; Last Name', 'back-in-stock-notifications-for-woocommerce'); ?></h4>
            <p><?php _e('When enabled, the subscribe modal collects the subscriber\'s first and last name in addition to their email. These are then available as merge tags in your email templates.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
            <p><?php _e('If disabled, only the email address is required — a lower-friction experience that can increase subscriptions.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
        </div>
        <div class="wsnm-help-box">
            <h4><?php _e('Button Text &amp; Modal Title', 'back-in-stock-notifications-for-woocommerce'); ?></h4>
            <p><?php _e('<strong>Button Text</strong> — the label on the "Notify Me" button shown on out-of-stock product pages.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
            <p><?php _e('<strong>Modal Title</strong> — the heading inside the subscribe popup. Keep it inviting, e.g. "Get notified when it\'s back!".', 'back-in-stock-notifications-for-woocommerce'); ?></p>
            <p><?php _e('Both fields are also overridable via WordPress filters for developers: <code>wsnm-text-cta</code> and <code>wsnm-modal-title</code>.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
        </div>
        <div class="wsnm-help-box">
            <h4><?php _e('Before &amp; After Form Text', 'back-in-stock-notifications-for-woocommerce'); ?></h4>
            <p><?php _e('Optional rich-text content displayed inside the modal, directly above and below the form fields. Useful for a short description, privacy note, or promotional message.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
            <p><?php _e('Supports <code>[wsnm-product-title]</code> and <code>[wsnm-product-price]</code> merge tags.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
        </div>
    </aside>
</div><!-- /.wsnm-page-layout -->
