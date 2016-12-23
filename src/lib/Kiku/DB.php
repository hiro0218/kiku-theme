<?php
namespace Kiku;

class DB {
    public function get_archive_list() {
        global $wpdb;

        $sql = "SELECT ID, post_title, post_date
                FROM $wpdb->posts
                WHERE post_status = 'publish'
                  AND post_date <= now()
                  AND post_type = 'post'
                ORDER BY post_date DESC";
        $archives = $wpdb->get_results($sql, ARRAY_A);

        return $archives;
    }

    public function get_frist_last_post_year() {
        global $wpdb;

        $sql = "SELECT YEAR(min(post_date_gmt)) AS firstdate,
                YEAR(max(post_date_gmt)) AS lastdate
                FROM $wpdb->posts
                WHERE
                 post_type = 'post' AND
                 post_status = 'publish'";
        $copyright_dates = $wpdb->get_results($sql);

        return $copyright_dates;
    }
}
