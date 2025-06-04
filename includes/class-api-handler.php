<?php
class Immens_API_Handler {
    private $api_base = 'https://studioimmens.com/wp-json/immens/v1/';
    
    public function get_dynamic_data($endpoint, $params = []) {
        $url = $this->api_base . $endpoint;
        if(!empty($params)) {
            $url = add_query_arg($params, $url);
        }
        
        $response = wp_remote_get($url, [
            'timeout' => 15,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->get_api_token()
            ]
        ]);
        
        if(is_wp_error($response)) {
            return [
                'success' => false,
                'error' => $response->get_error_message()
            ];
        }
        
        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }
    
    public function post_data($endpoint, $data) {
        $response = wp_remote_post($this->api_base . $endpoint, [
            'timeout' => 15,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->get_api_token(),
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode($data)
        ]);
        
        // ... gestione risposta ...
    }
    
    private function get_api_token() {
        // Ottieni token da impostazioni plugin o OAuth
        return get_option('immens_api_token', '');
    }

    public function sync_client_data() {
        $client_data = [
            'user_id' => get_current_user_id(),
            'digital_level' => get_user_meta(get_current_user_id(), 'immens_digital_level', true),
            'goals' => get_user_meta(get_current_user_id(), 'immens_business_goals', true),
            'missions' => $this->get_strategic_missions(),
            'last_sync' => time()
        ];
        
        return $this->post_data('sync/client-data', $client_data);
    }
    
    public function sync_service_requests($requests) {
        $prepared = [];
        
        foreach ($requests as $req) {
            $prepared[] = [
                'id' => $req->id,
                'user_id' => $req->user_id,
                'service_id' => $req->service_id,
                'service_name' => $this->get_service_name($req->service_id),
                'status' => $req->status,
                'created_at' => $req->created_at,
                'attachments' => $this->prepare_attachments($req->attachments)
            ];
        }
        
        return $this->post_data('sync/requests', $prepared);
    }
    
}
