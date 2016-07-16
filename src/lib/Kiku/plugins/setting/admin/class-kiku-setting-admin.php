<?php

class Kiku_Setting_Admin {
    private $plugin_name;
    private $version;
    private $message;
    private $options;

    public function __construct( $plugin_name, $version ) {
        $this->options = $this->get_mokuji_option([
            'kiku_twitter' => "",
            'kiku_appid' => '',
            'kiku_share_btn_twitter'  => true,
            'kiku_share_btn_facebook' => true,
            'kiku_share_btn_hatena'   => true,
            'kiku_share_btn_line'     => true,
            'kiku_insert_data_head' => '',
            'kiku_insert_data_bottom_of_more_tag' => '',
            'kiku_insert_data_bottom_of_more_tag_option' => '',
            'kiku_insert_data_bottom_of_content' => '',
        ]);
        add_action( 'admin_init', [$this, 'register_settings'] );
    }

    public function register_settings() {
        register_setting( 'kiku-settings-group', 'kiku_twitter' );
        register_setting( 'kiku-settings-group', 'kiku_appid' );
        register_setting( 'kiku-settings-group', 'kiku_share_btn_twitter' );
        register_setting( 'kiku-settings-group', 'kiku_share_btn_facebook' );
        register_setting( 'kiku-settings-group', 'kiku_share_btn_hatena' );
        register_setting( 'kiku-settings-group', 'kiku_share_btn_line' );
        register_setting( 'kiku-settings-group', 'kiku_insert_data_head' );
        register_setting( 'kiku-settings-group', 'kiku_insert_data_bottom_of_more_tag' );
        register_setting( 'kiku-settings-group', 'kiku_insert_data_bottom_of_more_tag_option' );
        register_setting( 'kiku-settings-group', 'kiku_insert_data_bottom_of_content' );
    }

    private function get_mokuji_option($defaults) {
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

    public function save_admin_options() {
        if ( !current_user_can('manage_options') ){
            return false;
        }

        $input = [
            'kiku_twitter' => trim( filter_input(INPUT_POST, 'kiku_twitter') ),
            'kiku_appid' => trim( filter_input(INPUT_POST, 'kiku_appid') ),
            'kiku_share_btn_twitter'  => (boolean) filter_input(INPUT_POST, 'kiku_share_btn_twitter') ? true : false,
            'kiku_share_btn_facebook' => (boolean) filter_input(INPUT_POST, 'kiku_share_btn_facebook') ? true : false,
            'kiku_share_btn_hatena'   => (boolean) filter_input(INPUT_POST, 'kiku_share_btn_hatena') ? true : false,
            'kiku_share_btn_line'     => (boolean) filter_input(INPUT_POST, 'kiku_share_btn_line') ? true : false,
            'kiku_insert_data_head'   => filter_input(INPUT_POST, 'kiku_insert_data_head'),
            'kiku_insert_data_bottom_of_more_tag' => filter_input(INPUT_POST, 'kiku_insert_data_bottom_of_more_tag'),
            'kiku_insert_data_bottom_of_more_tag_option' => (boolean) filter_input(INPUT_POST, 'kiku_insert_data_bottom_of_more_tag_option') ? true : false,
            'kiku_insert_data_bottom_of_content' => filter_input(INPUT_POST, 'kiku_insert_data_bottom_of_content'),
        ];

        $this->options = array_merge($this->options, $input);
        $result = update_option( 'kiku-setting-options', $this->options );

        return $result;
    }

    public function add_insert_data_head() {
        $data = get_option('kiku_insert_data_head');

        if ( !empty($data) ) {
            echo $data. PHP_EOL;
        }
    }

    public function add_insert_data_bottom_of_more_tag($content) {
        if ( !is_singular() ) {
            return $content;
        }

        $data = get_option('kiku_insert_data_bottom_of_more_tag');

        if ( empty($data) ) {
            return $content;
        }

        $pattern = '/(<[a-z0-9]+.*?>)?(<span id="more-[0-9]+"><\/span>)(<\/[a-z0-9]+>)?/i';
        preg_match($pattern, $content, $matches);

        if ( !empty($matches[0]) ){
            if (strpos($matches[0], '</p>') !== false){
                $content = preg_replace($pattern, '</p>'. $data, $content);
            } else {
                $content = preg_replace($pattern, '</p>'. $data .'<p>', $content);
            }
        } else if ( get_option('kiku_insert_data_bottom_of_more_tag_option') ) {
            $content = $data. $content;
        }

        return $content;
    }

    public function add_insert_data_bottom_of_content($content) {
        if ( !is_singular() ) {
            return $content;
        }

        $data = get_option('kiku_insert_data_bottom_of_content');

        if ( !empty($data) ) {
            $content .= $data;
        }

        return $content;
    }

}
