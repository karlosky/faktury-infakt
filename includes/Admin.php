<?php
/**
 * This class is for the admin part of module
 */


if ( !class_exists( 'FI_Admin') ) {
    
    class FI_Admin {
    
        public function __construct() {
        
            add_action( 'admin_menu', array( $this, 'settings_page' ) );
            add_action( 'admin_init', array( $this, 'save' ) );
            
        }
        
        
        /**
         * Print layout of the settings page
         *
         * @since 0.0.1
         */
        public function layout() {
            $options = get_option( 'fi_settings', array() );
            $key = isset( $options['key'] ) ? $options['key'] : '';
            ?>
                <div class="wrap">
                    <h2><?php echo get_admin_page_title(); ?></h2>
                    <form method="post">
                        <h3>1. <?php esc_attr_e( 'Dane niezbędne do prawidłowego działania wtyczki', 'fi' ); ?></h3>
                        <table class="form-table">
                            <tr>
                                <th><?php esc_attr_e( 'Klucz API', 'fi' ); ?></th>
                                <td>
                                    <p>
                                        <input type="text" name="fi[key]" value="<?php echo esc_attr_e( $key ); ?>" />
                                        <br>
                                        <span><?php printf( __( 'Klucz API należy wygenerować w <a href="%s" target="_blank">ustawieniach konta</a> klienta systemu Infakt.' ), 'https://www.infakt.pl/app/ustawienia/inne_opcje/api' ); ?></span>
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <button type="submit" class="button button-primary"><?php esc_attr_e( 'Zapisz', 'fi' ) ?></button>
                    </form>
                </div>
            <?php
        }
        
        
        /**
         * Create the settings page
         *
         * @since 0.0.1
         */
        public function settings_page() {
        
            add_submenu_page( 'options-general.php', __( 'Infakt', 'fi' ), __( 'Infakt', 'fi' ), 'manage_options', 'fi_settings', array( $this, 'layout' ) );
        
        }
        
        
        /**
         * Save the settings
         *
         * @since 0.0.1
         */
        public function save() {
        
            if ( isset( $_POST['fi'] ) ) {
                update_option( 'fi_settings', $_POST['fi'] );
            }
            
        }
       
    }
    
}
