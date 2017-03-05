<?php

namespace Kiku;

require_once KIKU_LIB_PATH . 'plugins/Template/Kiku-base.php';
require_once KIKU_LIB_PATH . 'plugins/Template/Kiku-loader.php';
require_once KIKU_LIB_PATH . 'plugins/mokuji/MokujiAdmin.php';


class Mokuji extends \Kiku_base {

    public function __construct() {
        $this->define_admin_hooks();
        $this->run();
    }

    private function define_admin_hooks() {
        $plugin_admin = new Mokuji_Admin();
        $this->loader = new \Kiku_Loader();
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_admin_page');
        $this->loader->add_filter('the_content', $plugin_admin, 'the_content', 200);
    }

}
