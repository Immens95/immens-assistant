<?php

defined('ABSPATH') or die('No script kiddies please!');

class Immens_Database {
    public static function activate() {
        self::create_tables();
    }

    private static function create_tables() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $tables = [
            "CREATE TABLE {$wpdb->prefix}immens_services (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
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
    
    public static function deactivate() {
        // Pulizia opzionale
    }
    
    public static function init() {
        // Inizializza dati base
        self::seed_services();
    }
    
    private static function seed_services() {
        // Inserimento servizi predefiniti
        $package_services = [
            'Articolo SEO ottimizzato 500/1000 parole',
            'Consulenza strategica 1h',
            'Mini audit sito e suggerimenti operativi',
            'Campagna DEM (Email Marketing)',
            'Progettazione landing page promozionale',
            'Impostazione Google My Business',
            'Setup e automazione newsletter',
            'Gestione intera strategia mensile (Premium)'
        ];
        
        $custom_services = [
            'Supporto tecnico urgente',
            'Consiglio strategico',
            'Contenuto personalizzato',
            'Nuova funzionalità sito'
        ];
        
        // ... codice per inserire nel DB ...
    }
}