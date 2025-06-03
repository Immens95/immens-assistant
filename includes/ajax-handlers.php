<?php

// Gestione invio servizi
add_action('wp_ajax_immens_submit_request', 'handle_service_request');
function handle_service_request() {
    check_ajax_referer('immens_nonce', 'nonce');
    
    $data = [
        'user_id' => get_current_user_id(),
        'service_id' => intval($_POST['service_id']),
        'custom_request' => sanitize_textarea_field($_POST['custom_request']),
        'attachments' => !empty($_FILES) ? process_attachments() : '',
        'status' => 'pending'
    ];
    
    // Salvataggio nel DB
    global $wpdb;
    $wpdb->insert("{$wpdb->prefix}immens_requests", $data);
    
    wp_send_json_success(['message' => 'Richiesta inviata con successo!']);
}

function process_attachments() {
    // Gestione upload file
}