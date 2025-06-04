<?php
class Immens_Sync_Manager {
    public static function init() {
        add_action('immens_daily_sync', [self::class, 'daily_sync_task']);
        add_action('immens_hourly_sync', [self::class, 'hourly_sync_task']);
    }
    
    public static function daily_sync_task() {
        // Sincronizzazione completa
        self::sync_all_client_data();
        self::sync_service_requests();
        self::sync_strategic_missions();
    }
    
    public static function hourly_sync_task() {
        // Sincronizzazione incrementale
        self::sync_recent_requests();
        self::sync_notifications();
    }
    
    private static function sync_all_client_data() {
        $api = new Immens_API_Handler();
        $api->sync_client_data();
    }
    
    private static function sync_service_requests() {
        global $wpdb;
        $table = $wpdb->prefix . 'immens_requests';
        $requests = $wpdb->get_results("SELECT * FROM $table WHERE sync_status = 0");
        
        if(!empty($requests)) {
            $api = new Immens_API_Handler();
            $result = $api->sync_service_requests($requests);
            
            // Aggiorna stato sincronizzazione
            foreach ($result as $item) {
                $wpdb->update($table, 
                    ['sync_status' => 1, 'central_id' => $item['central_id']],
                    ['id' => $item['local_id']]
                );
            }
        }
    }
    
    // ... altri metodi di sincronizzazione ...
}

// Registra cron jobs
register_activation_hook(__FILE__, function() {
    if (!wp_next_scheduled('immens_daily_sync')) {
        wp_schedule_event(time(), 'daily', 'immens_daily_sync');
    }
    
    if (!wp_next_scheduled('immens_hourly_sync')) {
        wp_schedule_event(time(), 'hourly', 'immens_hourly_sync');
    }
});