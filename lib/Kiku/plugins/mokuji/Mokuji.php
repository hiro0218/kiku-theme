<?php

namespace Kiku;

require_once KIKU_LIB_PATH . 'plugins/mokuji/MokujiAdmin.php';

define('MKJ_POSITION_BEFORE_FIRST_HEADING', 1);
define('MKJ_POSITION_CONTENTS_TOP', 2);
define('MKJ_POSITION_CONTENTS_BOTTOM', 3);
define('MKJ_POSITION_AFTER_FIRST_HEADING', 4);

class Mokuji {
    protected $mokuji_admin;
    public $filter_content;

    public function __construct() {
        $this->mokuji_admin = new Mokuji_Admin();
        $this->define_admin_hooks();
    }

    private function define_admin_hooks() {
        // admin page
        add_action('admin_menu', [$this->mokuji_admin, 'add_admin_page']);
        // post
        add_filter('the_content', [$this->mokuji_admin, 'the_content'], 200);
    }
}

$Mokuji = new Mokuji();
