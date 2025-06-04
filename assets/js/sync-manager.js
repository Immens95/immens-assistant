jQuery(document).ready(function($) {
    // Forza sincronizzazione completa
    $('#force-full-sync').click(function() {
        $.post(immens_data.ajax_url, {
            action: 'immens_force_full_sync',
            nonce: immens_data.nonce
        }, function(response) {
            if(response.success) {
                alert('Sincronizzazione completata con successo!');
            }
        });
    });
    
    // Sincronizzazione dati cliente
    $('#sync-client-data').click(function() {
        $.post(immens_data.ajax_url, {
            action: 'immens_sync_client_data',
            nonce: immens_data.nonce
        }, function(response) {
            if(response.success) {
                alert('Dati cliente sincronizzati!');
            }
        });
    });
    
    // Sincronizzazione richieste
    $('#sync-requests').click(function() {
        $.post(immens_data.ajax_url, {
            action: 'immens_sync_service_requests',
            nonce: immens_data.nonce
        }, function(response) {
            if(response.success) {
                alert(`${response.data.count} richieste sincronizzate!`);
            }
        });
    });
});