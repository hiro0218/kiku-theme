<?php
require_once KIKU_LIB_PATH . 'plugins/Template/Kiku-base.php';
require_once KIKU_LIB_PATH . 'plugins/Template/Kiku-loader.php';
// require_once KIKU_LIB_PATH . 'plugins/Template/Kiku-i18n.php';
require_once KIKU_LIB_PATH . 'plugins/mokuji/admin/class-kiku-mokuji-admin.php';

class Kiku_Mokuji extends Kiku_base {

    public function __construct() {
        $this->plugin_name = 'kiku-mokuji';
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->define_admin_hooks();
    }

    private function load_dependencies() {
        $this->loader = new Kiku_Loader();
    }

    private function define_admin_hooks() {
        $plugin_admin = new Kiku_Mokuji_Admin();
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_admin_page');
        $this->loader->add_filter('the_content', $plugin_admin, 'the_content', 200);
    }

}
