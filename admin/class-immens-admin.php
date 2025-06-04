<?php
class Immens_Admin {
    public static function init() {
        add_action('admin_menu', [self::class, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [self::class, 'enqueue_assets']);
        add_action('admin_bar_menu', [self::class, 'add_admin_bar_notifications'], 100);
    }

    public static function add_admin_menu() {
        add_menu_page(
            'Immens Assistant',
            'Immens',
            'manage_options',
            'immens-dashboard',
            [self::class, 'render_dashboard'],
            'dashicons-businessperson',
            1
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
                'nonce' => wp_create_nonce('immens_nonce'),
                'admin_url' => admin_url()
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
    
    public static function render_services() {
        require_once IMMENS_PLUGIN_DIR . 'admin/partials/services.php';
    }
    
    public static function render_value_content() {
        require_once IMMENS_PLUGIN_DIR . 'admin/partials/value-content.php';
    }
    
    public static function render_testimonials() {
        require_once IMMENS_PLUGIN_DIR . 'admin/partials/testimonials.php';
    }
    
    public static function render_notifications() {
        require_once IMMENS_PLUGIN_DIR . 'admin/partials/notifications.php';
    }
    
    public static function render_client_profile() {
        require_once IMMENS_PLUGIN_DIR . 'admin/partials/client-profile.php';
    }

    public static function add_admin_bar_notifications($admin_bar) {
        $unread_count = 3; // Sostituire con conteggio reale
        $admin_bar_enabled = get_user_meta(get_current_user_id(), 'immens_adminbar_notifications', true) ?: 'yes';
        
        if ($admin_bar_enabled === 'yes' && $unread_count > 0) {
            $admin_bar->add_node([
                'id'    => 'immens-notifications',
                'title' => '<span class="ab-icon dashicons dashicons-bell"></span> <span class="ab-label">' . $unread_count . '</span>',
                'href'  => admin_url('admin.php?page=immens-notifications'),
                'meta'  => [
                    'title' => __('Notifiche Immens'),
                    'class' => 'immens-notifications-menu'
                ],
            ]);
        }
    }

}