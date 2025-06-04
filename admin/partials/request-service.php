<?php
$package_services = Immens_Database::get_package_services();
$user_requests = Immens_Database::get_user_requests();
?>

<div class="immens-container">
    <div class="immens-card">
        <h2>Richiedi un Servizio</h2>
        
        <form id="immens-service-request" enctype="multipart/form-data">
            <div class="form-group">
                <label>Tipo di Servizio</label>
                <select id="service-type" class="immens-select">
                    <option value="package">Servizio a Pacchetto</option>
                    <option value="custom">Servizio su Richiesta</option>
                </select>
            </div>
            
            <div id="package-services" class="service-section">
                <h3>Servizi Disponibili</h3>
                <div class="services-grid">
                    <?php foreach ($package_services as $service): ?>
                        <div class="service-card">
                            <h4><?php echo esc_html($service['name']); ?></h4>
                            <p class="price">€ <?php echo number_format((float)$service['price'], 2); ?></p>
                            <p><?php echo esc_html($service['description']); ?></p>
                            <button type="button" class="immens-btn select-service" 
                                    data-id="<?php echo (int)$service['id']; ?>">
                                Seleziona
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div id="custom-services" class="service-section hidden">
                <div class="form-group">
                    <label>Categoria</label>
                    <select class="immens-select" name="custom_category">
                        <option value="support">Supporto tecnico urgente</option>
                        <option value="advice">Consiglio strategico</option>
                        <option value="content">Contenuto personalizzato</option>
                        <option value="feature">Nuova funzionalità</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Descrizione della Richiesta</label>
                    <textarea name="custom_request" rows="5" 
                              placeholder="Descrivi in dettaglio la tua richiesta..." 
                              class="immens-textarea"></textarea>
                </div>
            </div>
            
            <div class="form-group">
                <label>Allegati (facoltativo)</label>
                <input type="file" name="attachments[]" multiple>
            </div>
            
            <button type="submit" class="immens-btn">Invia Richiesta</button>
        </form>
    </div>
    
    <div class="immens-card">
        <h2>Richieste Precedenti</h2>
        <table class="immens-table">
            <thead>
                <tr>
                    <th>Servizio</th>
                    <th>Data</th>
                    <th>Stato</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user_requests as $request): ?>
                    <tr>
                        <td><?php echo esc_html($request['title']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($request['date'])); ?></td>
                        <td>
                            <span class="status-badge <?php echo esc_attr($request['status']); ?>">
                                <?php echo ucfirst(esc_html($request['status'])); ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>