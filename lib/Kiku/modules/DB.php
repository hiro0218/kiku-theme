<?php
namespace Kiku;

class DB {
    public function get_archive_list() {
        global $wpdb;

        $sql = "SELECT ID, post_title, post_date, YEAR(post_date_gmt) as post_year
                FROM $wpdb->posts
                WHERE post_status = 'publish'
                  AND post_date <= now()
                  AND post_type = 'post'
                ORDER BY post_date DESC";
        $archives = $wpdb->get_results($sql, ARRAY_A);

        return $archives;
    }
}
