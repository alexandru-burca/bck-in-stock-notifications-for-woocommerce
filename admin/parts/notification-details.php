<div class="notification_details_row">
    <div class="notification_details_column">
        <p class="notification_details_title">Notification Status:</p>
        <?php echo wp_kses_post($status_html); ?>
    </div>

    <?php if(!empty($product)): ?>
    <div class="notification_details_column">
        <p class="notification_details_title">Product:</p>
        <a href="<?php echo esc_url($product->get_permalink()); ?>" target="_blank"><?php echo esc_html($product->get_name()); ?></a>
    </div>
    <?php endif; ?>

    <?php if($flname_status): ?>
    <div class="notification_details_column">
        <p class="notification_details_title">Name:</p>
        <?php echo esc_html($first_name); ?> <?php echo esc_html($last_name); ?>
    </div>
    <?php endif; ?>
    <div class="notification_details_column">
        <p class="notification_details_title">Email:</p>
        <a href="<?php echo sprintf('mailto:%s', esc_html($email)); ?>"><?php echo esc_html($email); ?></a>
    </div>

    <?php if ($hubspot_enabled): ?>
    <div class="notification_details_column">
        <p class="notification_details_title">HubSpot:</p>
        <?php if ($hubspot_contact_id): ?>
            <?php if ($hubspot_portal_id): ?>
                <a href="<?php echo esc_url('https://app.hubspot.com/contacts/' . $hubspot_portal_id . '/contact/' . $hubspot_contact_id); ?>" target="_blank">
                    <?php _e('Successfully synced — view contact', 'back-in-stock-notifications-for-woocommerce'); ?>
                </a>
            <?php else: ?>
                <?php _e('Successfully synced', 'back-in-stock-notifications-for-woocommerce'); ?>
                (<?php echo __('Contact ID', 'back-in-stock-notifications-for-woocommerce'); ?>: <?php echo esc_html($hubspot_contact_id); ?>)
            <?php endif; ?>
            <?php if ($hubspot_synced_at): ?>
                <span style="color:#999;font-size:11px;display:block;"><?php echo esc_html($hubspot_synced_at); ?></span>
            <?php endif; ?>
        <?php elseif ($hubspot_error): ?>
            <span style="color:#dc3232;"><?php echo esc_html($hubspot_error); ?></span>
        <?php else: ?>
            <span style="color:#999;"><?php _e('Not synced', 'back-in-stock-notifications-for-woocommerce'); ?></span>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>