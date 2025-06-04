<?php
$package_services = Immens_Database::get_package_services();
// echo "<pre>";
// var_dump($package_services);
// echo "</pre>";
?>

<div class="immens-container">
    <div class="immens-card">
        <h2>Servizi & Pacchetti</h2>
        <p>Scegli tra i nostri servizi preconfigurati per ottenere risultati immediati</p>
        
        <div class="packages-grid">
            <?php foreach ($package_services as $service): 
                $features = ['Feature 1', 'Feature 2', 'Feature 3']; // Esempio
            ?>
                <div class="package-card">
                    <div class="package-header">
                        <h3><?php echo esc_html($service['name']); ?></h3>
                        <span class="package-price">€ <?php echo number_format((float)$service['price'], 2); ?></span>
                    </div>
                    <div class="package-body">
                        <p><?php echo esc_html($service['description']); ?></p>
                        <ul class="package-features">
                            <?php foreach ($features as $feature): ?>
                                <li><?php echo esc_html($feature); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="package-footer">
                        <button class="immens-btn request-package" 
                                data-id="<?php echo (int)$service['id']; ?>">
                            Richiedi Ora
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>