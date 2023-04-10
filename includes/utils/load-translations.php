<?php
    function mos_load_translations() {
        load_plugin_textdomain( 'mos', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }