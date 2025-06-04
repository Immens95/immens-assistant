<?php
class Immens_Notification_System {
    public function get_notifications() {
        $response = wp_remote_get('https://studioimmens.com/wp-json/immens/v1/notifications');
        
        if(!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
            return json_decode(wp_remote_retrieve_body($response), true);
        }
        
        return [];
    }
    
    public function mark_as_read($notification_id) {
        // Chiamata API per segnare come letta
        wp_remote_post('https://studioimmens.com/wp-json/immens/v1/notifications/read', [
            'body' => ['notification_id' => $notification_id]
        ]);
    }
}