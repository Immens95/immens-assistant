<?php
// Handle service requests
add_action('wp_ajax_immens_submit_request', 'immens_handle_service_request');
function immens_handle_service_request() {
    check_ajax_referer('immens_nonce', 'nonce');
    
    $user_id = get_current_user_id();
    $service_id = isset($_POST['service_id']) ? intval($_POST['service_id']) : 0;
    $custom_request = isset($_POST['custom_request']) ? sanitize_textarea_field($_POST['custom_request']) : '';
    
    // Save to database
    global $wpdb;
    $table = $wpdb->prefix . 'immens_requests';
    
    $data = [
        'user_id' => $user_id,
        'service_id' => $service_id,
        'custom_request' => $custom_request,
        'status' => 'pending',
        'created_at' => current_time('mysql')
    ];
    
    $result = $wpdb->insert($table, $data);
    
    if($result) {
        wp_send_json_success(['message' => 'Richiesta inviata con successo!']);
    } else {
        wp_send_json_error(['message' => 'Errore nel salvataggio']);
    }
}

// Handle package requests
add_action('wp_ajax_immens_request_package', 'immens_handle_package_request');
function immens_handle_package_request() {
    check_ajax_referer('immens_nonce', 'nonce');
    
    $user_id = get_current_user_id();
    $service_id = intval($_POST['service_id']);
    
    global $wpdb;
    $table = $wpdb->prefix . 'immens_requests';
    
    $data = [
        'user_id' => $user_id,
        'service_id' => $service_id,
        'status' => 'pending',
        'created_at' => current_time('mysql')
    ];
    
    $result = $wpdb->insert($table, $data);
    
    if ($result) {
        wp_send_json_success();
    } else {
        wp_send_json_error(['message' => 'Errore nel salvataggio']);
    }
}

// Handle testimonial submission
add_action('wp_ajax_immens_submit_testimonial', 'immens_handle_testimonial');
function immens_handle_testimonial() {
    check_ajax_referer('immens_nonce', 'nonce');
    
    $user_id = get_current_user_id();
    $phase = sanitize_text_field($_POST['phase']);
    $results = sanitize_textarea_field($_POST['results']);
    $testimonial = sanitize_textarea_field($_POST['testimonial']);
    
    global $wpdb;
    $table = $wpdb->prefix . 'immens_testimonials';
    
    $data = [
        'user_id' => $user_id,
        'phase' => $phase,
        'results' => $results,
        'feedback' => $testimonial,
        'created_at' => current_time('mysql')
    ];
    
    $result = $wpdb->insert($table, $data);
    
    if ($result) {
        wp_send_json_success(['message' => 'Testimonianza inviata con successo!']);
    } else {
        wp_send_json_error(['message' => 'Errore nel salvataggio']);
    }
}








// Toggle admin bar notifications
add_action('wp_ajax_immens_toggle_adminbar', function() {
    check_ajax_referer('immens_nonce', 'nonce');
    
    $status = sanitize_text_field($_POST['status']);
    update_user_meta(get_current_user_id(), 'immens_adminbar_notifications', $status);
    
    wp_send_json_success();
});

// Mark notification as read
add_action('wp_ajax_immens_mark_notification_read', function() {
    check_ajax_referer('immens_nonce', 'nonce');
    
    $notification_id = (int)$_POST['notification_id'];
    // Logica per segnare come letta nel database
    
    wp_send_json_success();
});

// Submit testimonial
add_action('wp_ajax_immens_submit_testimonial', function() {
    check_ajax_referer('immens_nonce', 'nonce');
    
    $user_id = get_current_user_id();
    $testimonial_data = [
        'before' => sanitize_textarea_field($_POST['before_situation']),
        'during' => sanitize_textarea_field($_POST['during_experience']),
        'after' => sanitize_textarea_field($_POST['after_results']),
        'rating' => (int)$_POST['rating'],
        'consent' => isset($_POST['publish_consent']) ? 1 : 0
    ];
    
    // Salva testimonianza nel database
    global $wpdb;
    $table = $wpdb->prefix . 'immens_testimonials';
    $wpdb->insert($table, [
        'user_id' => $user_id,
        'feedback' => json_encode($testimonial_data),
        'created_at' => current_time('mysql')
    ]);
    
    // Assegna punti fedeltà
    $current_points = (int)get_user_meta($user_id, 'immens_loyalty_points', true);
    $new_points = $current_points + 50;
    update_user_meta($user_id, 'immens_loyalty_points', $new_points);
    
    wp_send_json_success([
        'message' => 'Testimonianza inviata! Hai guadagnato 50 punti fedeltà',
        'new_points' => $new_points
    ]);
});