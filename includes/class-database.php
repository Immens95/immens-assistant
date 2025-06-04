<?php
class Immens_Database {
    public static function activate() {
        self::create_tables();
        self::seed_services();
    }

    private static function create_tables() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $tables = [
            "CREATE TABLE {$wpdb->prefix}immens_services (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL UNIQUE, 
                type ENUM('package', 'custom') NOT NULL,
                description TEXT,
                price DECIMAL(10,2),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) $charset_collate;",
            
            "CREATE TABLE {$wpdb->prefix}immens_requests (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT(20) UNSIGNED NOT NULL,
                service_id INT,
                custom_request TEXT,
                category VARCHAR(100),
                attachments TEXT,
                status ENUM('pending', 'in-progress', 'completed') DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP
            ) $charset_collate;",
            
            "CREATE TABLE {$wpdb->prefix}immens_testimonials (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT(20) UNSIGNED NOT NULL,
                phase ENUM('pre', 'post', 'success') NOT NULL,
                feedback TEXT NOT NULL,
                results TEXT,
                approved TINYINT(1) DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) $charset_collate;"
        ];
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        foreach ($tables as $table) {
            dbDelta($table);
        }
    }
    
    public static function init() {
        // Rimossa la chiamata a seed_services()
    }
    
    private static function seed_services() {
        global $wpdb;
        $table = $wpdb->prefix . 'immens_services';
        
        $package_services = [
            'Articolo SEO ottimizzato 500/1000 parole' => 49.99,
            'Consulenza strategica 1h' => 79.99,
            'Mini audit sito e suggerimenti operativi' => 99.99,
            'Campagna DEM (Email Marketing)' => 149.99,
            'Progettazione landing page promozionale' => 199.99,
            'Impostazione Google My Business' => 129.99,
            'Setup e automazione newsletter' => 89.99,
            'Gestione intera strategia mensile (Premium)' => 499.99
        ];
        
        $custom_services = [
            'Supporto tecnico urgente',
            'Consiglio strategico',
            'Contenuto personalizzato',
            'Nuova funzionalità sito'
        ];
        
        // Inserimento servizi pacchetto con controllo esistenza
        foreach ($package_services as $name => $price) {
            $exists = $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM $table WHERE name = %s", 
                $name
            ));
            
            if (!$exists) {
                $wpdb->insert($table, [
                    'name' => $name,
                    'type' => 'package',
                    'description' => 'Descrizione del servizio ' . $name,
                    'price' => $price
                ], ['%s', '%s', '%s', '%f']);
            }
        }
        
        // Inserimento servizi custom con controllo esistenza
        foreach ($custom_services as $name) {
            $exists = $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM $table WHERE name = %s", 
                $name
            ));
            
            if (!$exists) {
                $wpdb->insert($table, [
                    'name' => $name,
                    'type' => 'custom',
                    'description' => 'Servizio personalizzato su richiesta'
                ], ['%s', '%s', '%s']);
            }
        }
    }

    public static function get_package_services() {
        global $wpdb;
        return $wpdb->get_results(
            "SELECT * FROM {$wpdb->prefix}immens_services WHERE type = 'package'",
            ARRAY_A
        );
    }

    public static function get_user_requests($user_id = null) {
        if(!$user_id) $user_id = get_current_user_id();
        
        global $wpdb;
        return $wpdb->get_results($wpdb->prepare(
            "SELECT r.id, 
                    COALESCE(s.name, r.custom_request) AS title, 
                    r.created_at AS date, 
                    r.status
             FROM {$wpdb->prefix}immens_requests r
             LEFT JOIN {$wpdb->prefix}immens_services s ON r.service_id = s.id
             WHERE r.user_id = %d
             ORDER BY r.created_at DESC
             LIMIT 10",
            $user_id
        ), ARRAY_A);
    }

    public static function get_recent_requests($limit = 5) {
        global $wpdb;
        return $wpdb->get_results($wpdb->prepare(
            "SELECT r.id, 
                    COALESCE(s.name, r.custom_request) AS title, 
                    r.status
             FROM {$wpdb->prefix}immens_requests r
             LEFT JOIN {$wpdb->prefix}immens_services s ON r.service_id = s.id
             WHERE r.user_id = %d
             ORDER BY r.created_at DESC
             LIMIT %d",
            get_current_user_id(),
            $limit
        ), ARRAY_A);
    }
}