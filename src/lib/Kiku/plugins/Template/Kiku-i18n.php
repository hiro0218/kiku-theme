<?php

class Kiku_i18n {

    public function load_plugin_textdomain() {
        load_plugin_textdomain( 'kiku-setting', false, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' );
    }

}
