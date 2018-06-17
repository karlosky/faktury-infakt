<?php
/*
  Plugin Name: Faktury Infakt
  Description: Integracja sklepu WooCommerce z sytemem fakturowym Infakt.pl
  Version: 0.0.1
  Author: Karol Sawka
  Author URI: http://karlosky.pro
*/

define( 'FI_VERSION', '0.0.1' );

include_once( plugin_dir_path( __FILE__ ) . 'includes/Infakt.php' );
include_once( plugin_dir_path( __FILE__ ) . 'includes/Admin.php' );

if ( !class_exists( 'FI_Plugin') ) {
    
    class FI_Plugin {
    
        public function __construct() {
            $infakt = new FI_Infakt;
            $admin = new FI_Admin;
        }
        
    }

    $fi = new FI_Plugin;
}


