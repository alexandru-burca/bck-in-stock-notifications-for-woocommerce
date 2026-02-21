<?php


/**
 * WSNM_Woo_Stock_Notify_Me_Activator
 */
class WSNM_Woo_Stock_Notify_Me_Activator{

    public static $table_name = 'wsnm_actions';
    
    /**
     * activate
     *
     * @return void
     */
    public static function activate(){
        self::create_table();
        update_option( 'wsnm_db_version', '1.1' );
    }

    public static function create_table(){
        global $wpdb;
        $tableName = $wpdb->prefix . self::$table_name;
        $charset_collate = $wpdb->get_charset_collate();

        $sql_create_table = "CREATE TABLE $tableName (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            product_id bigint(20) NOT NULL,
            status tinyint(1) DEFAULT 0 NOT NULL,
            created_time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            complete_time datetime NULL DEFAULT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql_create_table );
    }

}