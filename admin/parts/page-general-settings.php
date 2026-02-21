<div class="wsnm-page-layout">
    <div class="wsnm-main">
        <form method="post">
            <div class="wsnm-settings-row">
                <h3>
                    <?php _e('Mode', 'back-in-stock-notifications-for-woocommerce'); ?>
                </h3>
                <div class="wsnm-field-row wsnm-field-row-flex">
                    <div class="wsnm-field-sub-row">
                        <label><input type="radio" id="wsnm_mode" name="wsnm_mode" value="manually" <?php echo ($mode) == 'manually' ? "checked" : ""; ?>><?php _e('Manually', 'back-in-stock-notifications-for-woocommerce'); ?></label>
                        <span class="dashicons dashicons-info-outline wsnm-tooltip">
                            <span class="wsnm-tooltip-text">
                                <?php _e('Is the default mode. The notifications are triggered manually by administrator directly from the product page.', 'back-in-stock-notifications-for-woocommerce'); ?>
                            </span>
                        </span>
                    </div>
                    <div class="wsnm-field-sub-row">
                        <label><input type="radio" id="wsnm_mode" name="wsnm_mode" value="automatically" <?php echo ($mode) == 'automatically' ? "checked" : ""; ?>><?php _e('Automatically', 'back-in-stock-notifications-for-woocommerce'); ?></label>
                        <span class="dashicons dashicons-info-outline wsnm-tooltip">
                            <span class="wsnm-tooltip-text">
                                <?php _e('When this mode is enabled, the notifications are triggered automatically by the stock status. The notifications are sent when the product is back in stock.', 'back-in-stock-notifications-for-woocommerce'); ?>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="wsnm-settings-row">
                <h3>
                    <?php _e('Button Style', 'back-in-stock-notifications-for-woocommerce'); ?>
                    <span class="dashicons dashicons-info-outline wsnm-tooltip">
                        <span class="wsnm-tooltip-text">
                            <?php _e('Change the default button style', 'back-in-stock-notifications-for-woocommerce'); ?>
                        </span>
                    </span>
                </h3>
                <div class="wsnm-field-row wsnm-field-row-flex">
                    <div class="wsnm-field-sub-row">
                        <label for="wsnm_button_background_color"><p><?php _e('Background color', 'back-in-stock-notifications-for-woocommerce'); ?></p></label>
                        <input type="text" value="<?php echo wp_kses($colors['background'], array()); ?>" id="wsnm_btn_background_color"  name="wsnm_btn_background_color">
                    </div>
                    <div class="wsnm-field-sub-row">
                        <label for="wsnm_button_background_color"><p><?php _e('Text color', 'back-in-stock-notifications-for-woocommerce'); ?></p></label>
                        <input type="text" value="<?php echo wp_kses($colors['text'], array()); ?>" id="wsnm_btn_text_color"  name="wsnm_btn_text_color">
                    </div>
                </div>
                <div class="wsnm-field-row">
                    <p style="font-weight:600;margin-bottom:6px;"><?php _e('Button Visibility', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                    <div class="wsnm-field-row wsnm-field-row-flex">
                        <div class="wsnm-field-sub-row">
                            <label><input type="radio" name="wsnm_button_display" value="both" <?php checked( $button_display, 'both' ); ?>> <?php _e('Show on both', 'back-in-stock-notifications-for-woocommerce'); ?></label>
                        </div>
                        <div class="wsnm-field-sub-row">
                            <label><input type="radio" name="wsnm_button_display" value="single" <?php checked( $button_display, 'single' ); ?>> <?php _e('Single product page only', 'back-in-stock-notifications-for-woocommerce'); ?></label>
                        </div>
                        <div class="wsnm-field-sub-row">
                            <label><input type="radio" name="wsnm_button_display" value="shop" <?php checked( $button_display, 'shop' ); ?>> <?php _e('Shop / listing pages only', 'back-in-stock-notifications-for-woocommerce'); ?></label>
                        </div>
                        <div class="wsnm-field-sub-row">
                            <label><input type="radio" name="wsnm_button_display" value="disabled" <?php checked( $button_display, 'disabled' ); ?>> <?php _e('Disabled', 'back-in-stock-notifications-for-woocommerce'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <?php wp_nonce_field( 'wsnm-settings-save', 'nonce-wsnm-settings' ); ?>
            <input type="submit" class="button" value="<?php _e('Save', 'back-in-stock-notifications-for-woocommerce'); ?>">
        </form>
    </div><!-- /.wsnm-main -->

    <aside class="wsnm-sidebar">
        <div class="wsnm-help-box">
            <h4><?php _e('Manually vs Automatically', 'back-in-stock-notifications-for-woocommerce'); ?></h4>
            <p><?php _e('<strong>Manually</strong> — you decide when to send notifications. Go to a product page in the admin, scroll to the "Notify Me" tab, and click "Send notifications now". Full control, zero surprises.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
            <p><?php _e('<strong>Automatically</strong> — notifications fire the moment a product\'s stock status changes back to "In stock". You can still pause individual products to hold off sending.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
        </div>
        <div class="wsnm-help-box">
            <h4><?php _e('Button Style', 'back-in-stock-notifications-for-woocommerce'); ?></h4>
            <p><?php _e('These colours apply to the "Notify Me" button shown on out-of-stock product pages. Use the colour picker or type any valid hex value (e.g. <code>#3d9cd2</code>).', 'back-in-stock-notifications-for-woocommerce'); ?></p>
            <p><?php _e('To change the button label or modal title, visit the <strong>Subscription Form</strong> tab.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
        </div>
        <div class="wsnm-help-box">
            <h4><?php _e('Button Visibility', 'back-in-stock-notifications-for-woocommerce'); ?></h4>
            <p><?php _e('<strong>Show on both</strong> — the subscribe button appears on the single product page and on shop/category/related product tiles. This is the default.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
            <p><?php _e('<strong>Single product page only</strong> — button only appears when a customer views the individual product.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
            <p><?php _e('<strong>Shop / listing pages only</strong> — button appears on product grid tiles (shop, categories, related products) but not on the single product page.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
            <p><?php _e('<strong>Disabled</strong> — hides the button everywhere. Existing subscriptions are unaffected.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
        </div>
    </aside>
</div><!-- /.wsnm-page-layout -->
