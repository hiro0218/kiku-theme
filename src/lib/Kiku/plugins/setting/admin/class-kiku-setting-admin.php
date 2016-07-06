<?php

class Kiku_Setting_Admin {
    private $plugin_name;
    private $version;
    private $message;
    private $options;

    public function __construct( $plugin_name, $version ) {
        $this->options = $this->get_mokuji_option([
            'kiku_twitter' => "",
        ]);
        add_action( 'admin_init', [$this, 'register_settings'] );
    }

    public function register_settings() {
        register_setting( 'kiku-settings-group', 'kiku_twitter' );
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

        $this->options = array_merge($this->options, [
            'kiku_twitter' => filter_input(INPUT_POST, 'kiku_twitter'),
        ]);

        return update_option( 'kiku-setting-options', $this->options );
    }
}
