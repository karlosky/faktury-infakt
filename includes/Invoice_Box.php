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
         * Render the invoice meta box
         *
         * @since 0.0.1
         */
        public function render_metabox( $post ) {
            
            global $woocommerce, $post;
            $order = new WC_Order($post->ID);
            $items = $order->get_items();
            $products = array();
            if ( $items ) { 
                foreach ( $items as $item ) {
                    $products[] = $item->data['name'];
                }
            }
            ?>
                <div id="fi-invoice-form">
                    <a href="#TB_inline?width=600&height=800&inlineId=fi-modal" class="button thickbox"><?php _e( 'Wystaw fakturę', 'fi' ); ?></a>
                    <div id="fi-modal" style="display:none;">
                        <h2><?php _e( 'Wystaw fakturę w Infakt.pl', 'fi' ); ?></h2>
                        <?php wp_nonce_field( 'custom_nonce_action', 'infakt_invoice_nonce' ); ?>
                        <p class="form-field">
                            <label for="first_name"><?php _e( 'Imię', 'fi' ); ?></label> <input type="text" name="first_name" value="<?php echo $order->data['billing']['first_name']; ?>">
                        </p>    
                        <p class="form-field">
                            <label for="last_name"><?php _e( 'Nazwisko', 'fi' ); ?></label> <input type="text" name="last_name" value="<?php echo $order->data['billing']['last_name']; ?>">
                        </p>    
                        <p class="form-field">
                            <label for="company"><?php _e( 'Firma', 'fi' ); ?></label> <input type="text" name="company" value="<?php echo $order->data['billing']['company']; ?>">
                        </p>    
                        <p class="form-field">
                            <label for="address_1"><?php _e( 'Adres 1', 'fi' ); ?></label> <input type="text" name="address_1" value="<?php echo $order->data['billing']['address_1']; ?>">
                        </p>    
                        <p class="form-field">
                            <label for="address_2"><?php _e( 'Adres 2', 'fi' ); ?></label> <input type="text" name="address_2" value="<?php echo $order->data['billing']['address_2']; ?>">
                        </p>    
                        <p class="form-field">
                            <label for="postcode"><?php _e( 'Kod pocztowy', 'fi' ); ?></label> <input type="text" name="postcode" value="<?php echo $order->data['billing']['postcode']; ?>">
                        </p>    
                        <p class="form-field">
                            <label for="city"><?php _e( 'Miejscowość', 'fi' ); ?></label> <input type="text" name="city" value="<?php echo $order->data['billing']['city']; ?>">
                        </p>    
                        <p class="form-field">
                            <label for="state"><?php _e( 'Województwo', 'fi' ); ?></label> <input type="text" name="state" value="<?php echo $order->data['billing']['state']; ?>">
                        </p>    
                        <p class="form-field">
                            <label for="country"><?php _e( 'Kraj', 'fi' ); ?></label> <input type="text" name="country" value="<?php echo $order->data['billing']['country']; ?>">
                        </p>
                        <p class="form-field">
                            <label for="paid"><?php _e( 'Zapłacona kwota', 'fi' ); ?></label> <input type="text" name="paid" value="">
                        </p>
                        <p>
                            <strong><?php _e( 'Zakupione produkty', 'fi' ); ?></strong>
                            <ul>
                                <?php foreach ( $products as $product ) : ?>
                                    <li><?php echo $product; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </p>
                        <p class="form-field">
                            <label><input type="radio" name="invoice_type" value="faktura"><?php _e( 'Faktura', 'fi' ); ?></label> 
                            <label><input type="radio" name="invoice_type" value="proforma"><?php _e( 'Pro-forma', 'fi' ); ?></label> 
                        </p>
                        <p class="form-field">
                            <button name="fi-new-invoice" id="fi-new-invoice" class="button"><?php _e( 'Wystaw dokument', 'fi' ); ?></button>
                        </p>
                    </div>
                </div>
                
            <?php
            
        }
     
     
        /**
         * Save Invoice meta box data
         *
         * @since 0.0.1
         */
        public function save_metabox( $post_id, $post ) {
        
            // Nonce - security
            $nonce_name   = isset( $_POST['infakt_invoice_nonce'] ) ? $_POST['infakt_invoice_nonce'] : '';
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
