<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

require KIKU_LIB_PATH . 'plugins/mokuji/includes/class-kiku-mokuji.php';

function run_kiku_mokuji() {
	$plugin = new Kiku_Mokuji();
	$plugin->run();
}
run_kiku_mokuji();
