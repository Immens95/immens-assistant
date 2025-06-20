
jQuery(document).ready(function($) {
    // Toggle service types
    $('#service-type').change(function() {
        $('.service-section').addClass('hidden');
        if($(this).val() === 'package') {
            $('#package-services').removeClass('hidden');
        } else {
            $('#custom-services').removeClass('hidden');
        }
    });
    
    // Handle service request
    $('#immens-service-request').submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        // Aggiungi dati aggiuntivi
        formData.append('action', 'immens_submit_request');
        formData.append('nonce', immens_data.nonce);
        
        $.ajax({
            url: immens_data.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    alert('Richiesta inviata con successo!');
                    location.reload();
                } else {
                    alert('Errore: ' + response.data);
                }
            },
            error: function(xhr) {
                alert('Errore di sistema: ' + xhr.responseText);
            }
        });
    });
    
    // Tab switching
    $('.tab-link').click(function() {
        const tab = $(this).data('tab');
        $('.tab-link').removeClass('active');
        $('.tab-content').removeClass('active');
        $(this).addClass('active');
        $('#' + tab).addClass('active');
    });
    
    // Request package directly
    $('.request-package').click(function() {
        const serviceId = $(this).data('id');
        $.post(immens_data.ajax_url, {
            action: 'immens_request_package',
            nonce: immens_data.nonce,
            service_id: serviceId
        }, function(response) {
            if(response.success) {
                alert('Pacchetto richiesto con successo!');
                window.location.href = immens_data.admin_url + 'admin.php?page=immens-request-service';
            } else {
                alert('Errore: ' + response.data);
            }
        }).fail(function(xhr) {
            alert('Errore di sistema: ' + xhr.responseText);
        });
    });
    
    // Notification filtering
    $('.notification-filters button').click(function() {
        const category = $(this).data('category');
        $('.notification-filters button').removeClass('active');
        $(this).addClass('active');
        
        if (category === 'all') {
            $('.notification-item').show();
        } else {
            $('.notification-item').hide();
            $(`.notification-item[data-type="${category}"]`).show();
        }
    });

        // Admin Bar Notifications Toggle
    $('#adminbar-notifications').change(function() {
        const enabled = $(this).is(':checked') ? 'yes' : 'no';
        $.post(immens_data.ajax_url, {
            action: 'immens_toggle_adminbar',
            nonce: immens_data.nonce,
            status: enabled
        });
    });
    
    // Mark notifications as read
    $('.notification-dismiss').click(function() {
        const $item = $(this).closest('.notification-item');
        const id = $item.data('id');
        
        $.post(immens_data.ajax_url, {
            action: 'immens_mark_notification_read',
            nonce: immens_data.nonce,
            notification_id: id
        }, function() {
            $item.removeClass('unread').find('.notification-badge').remove();
        });
    });
    
    // Testimonial wizard
    let currentStep = 1;
    const totalSteps = 3;
    
    $('.next-step').click(function() {
        if (currentStep < totalSteps) {
            $(`.wizard-step[data-step="${currentStep}"]`).removeClass('active');
            currentStep++;
            $(`.wizard-step[data-step="${currentStep}"]`).addClass('active');
            $('.prev-step').prop('disabled', false);
            
            if (currentStep === totalSteps) {
                $('.next-step').hide();
                $('.submit-testimonial').prop('disabled', false).show();
            }
        }
    });
    
    $('.prev-step').click(function() {
        if (currentStep > 1) {
            $(`.wizard-step[data-step="${currentStep}"]`).removeClass('active');
            currentStep--;
            $(`.wizard-step[data-step="${currentStep}"]`).addClass('active');
            $('.submit-testimonial').hide();
            $('.next-step').show();
            
            if (currentStep === 1) {
                $(this).prop('disabled', true);
            }
        }
    });
    
    // Star rating
    $('.star-rating .star').hover(
        function() {
            const value = $(this).data('value');
            $(this).prevAll().addBack().addClass('active');
        },
        function() {
            $('.star-rating .star').removeClass('active');
        }
    ).click(function() {
        const value = $(this).data('value');
        $(this).addClass('selected').prevAll().addClass('selected');
        $(this).nextAll().removeClass('selected');
    });
    
    // Read articles
    $('.read-more').click(function() {
        const $card = $(this).closest('.article-card');
        $card.toggleClass('expanded');
        
        if ($card.hasClass('expanded')) {
            $(this).text('Riduci');
        } else {
            $(this).text('Leggi tutto');
        }
    });
    
});