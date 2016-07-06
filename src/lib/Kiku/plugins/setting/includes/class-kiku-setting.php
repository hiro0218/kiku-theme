<?php
class Kiku_Setting {
    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {
        $this->plugin_name = 'kiku-setting';
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->define_admin_hooks();
    }

    private function load_dependencies() {
        require_once KIKU_LIB_PATH . 'plugins/setting/includes/class-kiku-setting-loader.php';
        // require_once KIKU_LIB_PATH . 'plugins/setting/includes/class-kiku-setting-i18n.php';

        require_once KIKU_LIB_PATH . 'plugins/setting/admin/class-kiku-setting-admin.php';

        $this->loader = new Kiku_Setting_Loader();
    }

    private function define_admin_hooks() {
        $plugin_admin = new Kiku_Setting_Admin( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_admin_page');
    }

    public function run() {
        $this->loader->run();
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_loader() {
        return $this->loader;
    }

    public function get_version() {
        return $this->version;
    }

}
