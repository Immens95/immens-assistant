<?php
/**
 * Plugin Name: Immens Assistant
 * Description: Assistente completo per la gestione dei servizi digitali
 * Version: 1.0.0
 * Author: Il tuo Nome
 */

defined('ABSPATH') or die('No script kiddies please!');

// Definisci costanti
define('IMMENS_VERSION', '1.0.0');
define('IMMENS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('IMMENS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Carica file principali
require_once IMMENS_PLUGIN_DIR . 'includes/class-database.php';
require_once IMMENS_PLUGIN_DIR . 'admin/class-immens-admin.php';

// Registra attivazione/disattivazione
register_activation_hook(__FILE__, ['Immens_Database', 'activate']);
register_deactivation_hook(__FILE__, ['Immens_Database', 'deactivate']);

// Inizializzazione
add_action('plugins_loaded', 'init_immens_assistant');
function init_immens_assistant() {
    Immens_Database::init();
    Immens_Admin::init();
}