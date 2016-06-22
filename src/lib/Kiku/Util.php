<?php
class Util {

    public static $copyright_year;

    public static function get_copyright_year() {
        if (self::$copyright_year === null) {
            self::$copyright_year = self::_get_copyright_year();
        }
        
        return self::$copyright_year;
    }

    public static  function _get_copyright_year() {
        global $wpdb;

        $sql = "SELECT YEAR(min(post_date_gmt)) AS firstdate,
                YEAR(max(post_date_gmt)) AS lastdate
                FROM $wpdb->posts
                WHERE post_status = 'publish'";

        $output = '';
        $copyright_dates = $wpdb->get_results($sql);

        if($copyright_dates) {
            $copyright = $copyright_dates[0]->firstdate;
            if( $copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate ) {
                $copyright .= '-' . $copyright_dates[0]->lastdate;
            }
            $output = $copyright;
        }

        return $output;
    }

}
