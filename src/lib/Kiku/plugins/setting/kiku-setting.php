<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

require KIKU_LIB_PATH . 'plugins/setting/includes/class-kiku-setting.php';

function run_kiku_setting() {
	$plugin = new Kiku_Setting();
	$plugin->run();
}
run_kiku_setting();
