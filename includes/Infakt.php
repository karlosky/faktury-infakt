<?php

if ( !class_exists( 'Infakt') ) {

    class Infakt{
        
        private $key;
        private $url;
        
        
        public function __construct() {
            $this->key = '#';
            $this->url = '#';
        }
        
        //create request with api key
        public function request( $query ) {
            return $this->url . $query;
        }
        

        //get data
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
        
        
        //get all invoices
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
