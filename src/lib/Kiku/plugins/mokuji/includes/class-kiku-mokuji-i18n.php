<?php

class Kiku_Mokuji_i18n {

    public function load_plugin_textdomain() {
        load_plugin_textdomain( 'kiku-mokuji', false, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' );
    }

}
