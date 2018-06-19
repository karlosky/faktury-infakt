<?php
/**
 * Meta box with the invoice actions
 * It's visible on the order page (admin)
 */
 
if ( !class_exists( 'FI_Invoice_Box') ) {

    class FI_Invoice_Box {
     

        public function __construct() {
        
            if ( is_admin() ) {
                add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
                add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
            }
     
        }
     
     
        /**
         * Invoice meta box initialization
         *
         * @since 0.0.1
         */
        public function init_metabox() {
        
            add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
            add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );
            
        }
     
     
        /**
         * Add the invoice meta box
         *
         * @since 0.0.1
         */
        public function add_metabox() {
        
            add_meta_box(
                'infakt-box',
                __( 'Faktury Infakt', 'fi' ),
                array( $this, 'render_metabox' ),
                'shop_order',
                'side',
                'default'
            );
     
        }
     
     
        /**
         * Rendere the invoice meta box
         *
         * @since 0.0.1
         */
        public function render_metabox( $post ) {
        
            // Add nonce for security and authentication.
            wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
            
        }
     
     
        /**
         * Save Invoice meta box data
         *
         * @since 0.0.1
         */
        public function save_metabox( $post_id, $post ) {
        
            // Nonce - security
            $nonce_name   = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
            $nonce_action = 'custom_nonce_action';
     
            if ( ! isset( $nonce_name ) ) {
                return;
            }
     
            if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
                return;
            }
     
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
     
            if ( wp_is_post_autosave( $post_id ) ) {
                return;
            }
     
            if ( wp_is_post_revision( $post_id ) ) {
                return;
            }
            
        }
    }
    
}
