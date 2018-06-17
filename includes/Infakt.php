<?php
/**
 * This class should be used fot the integrations with Infakt.
 */

 
if ( !class_exists( 'FI_Infakt') ) {

    class FI_Infakt{
        
        private $key;
        private $url;
        
        
        public function __construct() {
        
            $options = get_option( 'fi_settings', array() );
            $this->key = $options && isset( $options['key'] ) ? $options['key'] : 0;
            $this->url = 'https://api.infakt.pl/api/v3/';
            
        }
        
        /**
         * Create request with api key
         *
         * @since 0.0.1
         */
        public function request( $query ) {
        
            return $this->url . $query;
            
        }
        

        /**
         * Execute the API request
         *
         * @since 0.0.1
         */
        public function execute( $query, $encode = true, $headers = array() ) {
        
            $request = $this->request( $query );
            $session = curl_init( $request );
            curl_setopt( $session, CURLOPT_RETURNTRANSFER, TRUE );
            if ( !count( $headers ) ) {
                $headers[] = 'Content-Type: application/json;';
                $headers[] = 'X-inFakt-ApiKey: ' . $this->key;
                $headers[] = 'Accept: application/json';
            }
            curl_setopt( $session, CURLOPT_HTTPHEADER , $headers );
            $response = curl_exec( $session );
            curl_close( $session );
            if ( !$response ) {
                throw new Exception( 'Curl error: ' . curl_error( $session ) );
            }
            return $response;
            
        }
        
        
        /**
         * @api: get all invoices
         *
         * @since 0.0.1
         */
        public function get_invoices() {
        
            try {
                $query = 'invoices.json';
                $response = $this->execute( $query );
            } catch ( Exception $e ) {
                $response = array( 'status' => 'error', 'msg' => $e->getMessage() );
            }
            return $response;
            
        }
        
    }

}
