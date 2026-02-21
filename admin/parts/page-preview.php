<div class="wrap">
    <!-- <h2></h2> to display notices under it -->
    <h2></h2>
    <nav class="wsnm-tab-wrapper">
        <img src="<?php echo WSNM_URL . 'admin/img/logo.jpg'; ?>" alt="<?php _e('Back in Stock', 'back-in-stock-notifications-for-woocommerce'); ?>" class="wsnm-settings-logo">
        <span style="font-weight:600; color:#1d2327; font-size:14px;">
            <?php _e('Subscription Form Preview', 'back-in-stock-notifications-for-woocommerce'); ?>
        </span>
        <a href="<?php echo esc_url($back_url); ?>" class="button" style="margin-left:auto;">
            &larr; <?php _e('Back to Settings', 'back-in-stock-notifications-for-woocommerce'); ?>
        </a>
    </nav>

    <div class="wsnm-content">
        <div class="wsnm-page-layout">

            <div class="wsnm-main">
                <div style="background:#fff; border:1px solid #dcdcde; border-radius:2px; padding:40px; text-align:center;">
                    <p style="margin:0 0 24px; color:#50575e; font-size:13px;">
                        <?php _e('This is how the button appears on out-of-stock product pages. Click it to open the modal.', 'back-in-stock-notifications-for-woocommerce'); ?>
                    </p>
                    <?php echo $preview_cta; ?>
                </div>
            </div>

            <aside class="wsnm-sidebar">
                <div class="wsnm-help-box">
                    <h4><?php _e('What you\'re seeing', 'back-in-stock-notifications-for-woocommerce'); ?></h4>
                    <p><?php _e('A live preview of your subscription form using your current settings — button colours, modal title, name fields, and before/after text are all reflected here.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                    <p><?php _e('Any changes saved in <strong>Subscription Form</strong> settings will appear here on next preview load.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                </div>
                <div class="wsnm-help-box">
                    <h4><?php _e('How to test', 'back-in-stock-notifications-for-woocommerce'); ?></h4>
                    <ol>
                        <li><?php _e('Click the button to open the modal.', 'back-in-stock-notifications-for-woocommerce'); ?></li>
                        <li><?php _e('Check the layout, title, fields, and any before/after text.', 'back-in-stock-notifications-for-woocommerce'); ?></li>
                        <li><?php _e('Close with the &times; button or by clicking outside the modal.', 'back-in-stock-notifications-for-woocommerce'); ?></li>
                    </ol>
                    <p><?php _e('<strong>Note:</strong> Form submission is disabled in preview mode.', 'back-in-stock-notifications-for-woocommerce'); ?></p>
                </div>
            </aside>

        </div><!-- /.wsnm-page-layout -->
    </div><!-- /.wsnm-content -->
</div><!-- /.wrap -->

<?php echo $preview_modal; ?>

<script>
jQuery(document).ready(function($) {
    // Override public JS handler — show pre-rendered modal instead of AJAX
    $(document).off('click', '#wsnm-cta');
    $(document).on('click', '#wsnm-cta', function() {
        $('#wsnm-modal').show();
    });
    // Close button
    $('.wsnm-modal-close').on('click', function() {
        $('#wsnm-modal').hide();
    });
    // Backdrop click (override public JS remove() with hide())
    $(window).off('click');
    $(window).on('click', function(e) {
        if (e.target.id === 'wsnm-modal') {
            $('#wsnm-modal').hide();
        }
    });
    // Submit interception
    $('#wsnm-submit-form').on('click touch', function(e) {
        e.stopPropagation();
        $('#wsnm-ajax-response').html('<em style="color:#e07400;"><?php echo esc_js(__('Preview mode — submission is disabled.', 'back-in-stock-notifications-for-woocommerce')); ?></em>');
    });
});
</script>
