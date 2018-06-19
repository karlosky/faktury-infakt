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
include_once( plugin_dir_path( __FILE__ ) . 'includes/Invoice_Box.php' );

if ( !class_exists( 'FI_Plugin') ) {
    
    class FI_Plugin {
    
        private $infakt;
        private $admin;
        private $invoice_box;
    
        public function __construct() {
        
            $infakt = new FI_Infakt;
            $admin = new FI_Admin;
            $invoice_box = new FI_Invoice_Box;
            
            //hooks
            add_action( 'admin_enqueue_scripts', array( $this, 'add_scripts' ) );
            
            //ajax functions
            add_action( 'wp_ajax_fi_add_invoice', array( $this, 'add_invoice' ) );
            
        }
        
        
        /*
        * Add JS script on the backend
        *
        * @since 0.0.1
        */
        public function add_scripts() {
        
            wp_enqueue_script( 'fi-script', plugin_dir_url( __FILE__ ) . 'admin/js/fi-script.js', array( 'jquery' ), time() );
            
        }
        
        
        /*
        * Add invoice to Infakt system
        *
        * @since 0.0.1
        */
        public function add_invoice() {
        
            if ( isset( $_POST['fi-invoice'] ) ) {
                $invoice_data = unserialize( $_POST['fi-invoice'] );
                $return = $this->infakt->add_invoice( $invoice_data );
                if ( $return ) {
                    wp_send_json_success( $return );
                } else {
                    wp_send_json_error( $return );
                }
            }
            
        }
        
    }
    if ( is_admin() ) {
        $fi = new FI_Plugin;
    }
}


