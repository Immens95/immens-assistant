<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

global $wpdb;

// Delete plugin tables
$tables = [
    $wpdb->prefix . 'immens_services',
    $wpdb->prefix . 'immens_requests',
    $wpdb->prefix . 'immens_testimonials'
];

foreach ($tables as $table) {
    $wpdb->query("DROP TABLE IF EXISTS $table");
}

// Delete plugin options
delete_option('immens_db_version');