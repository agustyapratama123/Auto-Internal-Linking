<?php
class Codewpx_AIL_Database {
    public static function install() {
        global $wpdb;
        
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        
        dbDelta("
            CREATE TABLE {$wpdb->prefix}codewpx_link_data (
                post_id bigint(20) NOT NULL,
                seo_score float DEFAULT 0.5,
                click_count int DEFAULT 0,
                last_updated datetime DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (post_id)
            ) {$wpdb->get_charset_collate()};
        ");
    }
}