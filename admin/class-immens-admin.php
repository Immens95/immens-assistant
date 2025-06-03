<?php

defined('ABSPATH') or die('No script kiddies please!');

class Immens_Admin {
    public static function init() {
        add_action('admin_menu', [self::class, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [self::class, 'enqueue_assets']);
    }

    public static function add_admin_menu() {
        add_menu_page(
            'Immens Assistant',
            'Immens',
            'manage_options',
            'immens-dashboard',
            [self::class, 'render_dashboard'],
            'dashicons-businessperson',
            6
        );
        
        $submenu_items = [
            ['Richiedi Servizio', 'request-service'],
            ['Servizi & Pacchetti', 'services'],
            ['Valore Continuo', 'value-content'],
            ['Testimonianze', 'testimonials'],
            ['Notifiche', 'notifications'],
            ['Profilo Cliente', 'client-profile']
        ];
        
        foreach ($submenu_items as $item) {
            add_submenu_page(
                'immens-dashboard',
                $item[0],
                $item[0],
                'manage_options',
                'immens-' . $item[1],
                [self::class, 'render_' . str_replace('-', '_', $item[1])]
            );
        }
    }
    
    public static function enqueue_assets($hook) {
        if (strpos($hook, 'immens-') !== false) {
            wp_enqueue_style(
                'immens-admin-css', 
                IMMENS_PLUGIN_URL . 'admin/css/immens-admin.css',
                [],
                IMMENS_VERSION
            );
            
            wp_enqueue_script(
                'immens-admin-js',
                IMMENS_PLUGIN_URL . 'admin/js/immens-admin.js',
                ['jquery'],
                IMMENS_VERSION,
                true
            );
            
            wp_localize_script('immens-admin-js', 'immens_data', [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('immens_nonce')
            ]);
        }
    }
    
    // Funzioni di rendering per ogni pagina
    public static function render_dashboard() {
        require_once IMMENS_PLUGIN_DIR . 'admin/partials/dashboard.php';
    }
    
    public static function render_request_service() {
        require_once IMMENS_PLUGIN_DIR . 'admin/partials/request-service.php';
    }
    
    // ... altre funzioni di rendering ...
}