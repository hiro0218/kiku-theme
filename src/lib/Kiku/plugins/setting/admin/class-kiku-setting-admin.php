<?php

class Kiku_Setting_Admin {
    private $plugin_name;
    private $version;
    private $message;
    private $options;
    private $exclude_post_types = ['attachment', 'revision', 'nav_menu_item', 'safecss'];

    public function __construct( $plugin_name, $version ) {
        add_action( 'admin_init', [$this, 'register_settings'] );
    }

    public function register_settings() {
        register_setting( 'kiku-settings-group', 'kiku_twitter' );
        register_setting( 'kiku-settings-group', 'kiku_appid' );
        register_setting( 'kiku-settings-group', 'kiku_amazon_api_key' );
        register_setting( 'kiku-settings-group', 'kiku_amazon_secret_key' );
        register_setting( 'kiku-settings-group', 'kiku_amazon_associate_tag' );
        register_setting( 'kiku-settings-group', 'kiku_author_page' );
        register_setting( 'kiku-settings-group', 'kiku_share_btn_twitter' );
        register_setting( 'kiku-settings-group', 'kiku_share_btn_facebook' );
        register_setting( 'kiku-settings-group', 'kiku_share_btn_hatena' );
        register_setting( 'kiku-settings-group', 'kiku_share_btn_line' );
        register_setting( 'kiku-settings-group', 'kiku_insert_data_head' );

        // ads1
        register_setting( 'kiku-settings-group', 'kiku_ads1_content' );
        register_setting( 'kiku-settings-group', 'kiku_ads1_script' );
        register_setting( 'kiku-settings-group', 'kiku_ads1_more_tag_option' );
        register_setting( 'kiku-settings-group', 'kiku_ads1_post_types' );
        // ads2
        register_setting( 'kiku-settings-group', 'kiku_ads2_content' );
        register_setting( 'kiku-settings-group', 'kiku_ads2_script' );
        register_setting( 'kiku-settings-group', 'kiku_ads2_post_types' );
        // ads3
        register_setting( 'kiku-settings-group', 'kiku_ads3_content' );
        register_setting( 'kiku-settings-group', 'kiku_ads3_script' );

        register_setting( 'kiku-settings-group', 'kiku_exclude_category_frontpage', [$this, 'check_category_list']);
    }

    private function get_setting_option($defaults) {
         $options = get_option('kiku-setting-options', $defaults);
         $options = wp_parse_args( $options, $defaults );
         return $options;
    }

    public function add_admin_page() {
        add_theme_page(
            __('Setting', 'kiku'),  // page_title
            __('Setting', 'kiku'),  // menu_title
            'manage_options',       // capability
            'setting',              // menu_slug
            [$this, 'admin_options']
        );
    }

    public function admin_options(){
        require_once KIKU_LIB_PATH . 'plugins/setting/admin/partials/kiku-setting-admin-display.php';
    }

    public function check_category_list($string) {
        $array = array_map('intval', explode(",", $string));
        $array = array_values( array_unique($array) );
        $array = array_filter($array, function($val) {
            return is_int($val) && ($val !== 0);
        });
        $string = implode(",", $array);
        return $string;
    }

    public function add_insert_data_head() {
        // insert_data_head
        $head_data = get_option('kiku_insert_data_head');

        if (!empty($head_data)) {
            echo $head_data. PHP_EOL;
        }
    }

    public function add_insert_data_bottom_of_more_tag($content) {
        if (!$this->is_insert_post_type(get_option('kiku_ads1_post_types'))) {
            return $content;
        }

        $data = get_option('kiku_insert_data_bottom_of_more_tag');
        $option = get_option('kiku_ads1_more_tag_option') ? true : false;

        if (empty($data)) {
            return $content;
        }

        $pattern = '/(<[a-z0-9]+.*?>)?(<span id="more-[0-9]+"><\/span>)(<\/[a-z0-9]+>)?/i';
        preg_match($pattern, $content, $matches);

        if (!empty($matches[0])) {
            if (strpos($matches[0], '</p>') !== false) {
                return preg_replace($pattern, '</p>'. $data, $content);
            }
            return preg_replace($pattern, '</p>'. $data .'<p>', $content);
        } else if ($option) {
            return $data. $content;
        }

        return $content;
    }

    public function add_insert_data_bottom_of_content($content) {
        if (!$this->is_insert_post_type(get_option('kiku_ads2_post_types'))) {
            return $content;
        }

        $data = get_option('kiku_insert_data_bottom_of_content');

        if ( !empty($data) ) {
            $content .= $data;
        }

        return $content;
    }

    private function is_insert_post_type($selected_post_types) {
        $result = false;

        if ( empty($selected_post_types) ) {
            return $result;
        }

        foreach ($selected_post_types as $post_type) {
            if ( $post_type === get_post_type() ) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    public function exclude_category_from_frontpage($query) {
        if ( $query->is_home() && $query->is_main_query() ) {
            $cats_str = get_option('kiku_exclude_category_frontpage');
            if (!empty($cats_str)) {
                $query->set('category__not_in', explode(",", $cats_str));
            }
        }

        return $query;
    }

}
