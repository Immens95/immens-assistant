<div class="immens-container">
    <div class="immens-card">
        <h2>Configurazione Integrazione API</h2>
        
        <form method="post" action="options.php">
            <?php settings_fields('immens_api_settings'); ?>
            <?php do_settings_sections('immens_api_settings'); ?>
            
            <div class="form-group">
                <label>Endpoint API Studio Immens</label>
                <input type="url" name="immens_api_endpoint" 
                       value="<?php esc_attr(get_option('immens_api_endpoint')); ?>" 
                       class="immens-input" required>
            </div>
            
            <div class="form-group">
                <label>Token API</label>
                <input type="text" name="immens_api_token" 
                       value="<?php esc_attr(get_option('immens_api_token')); ?>" 
                       class="immens-input" required>
            </div>
            
            <div class="form-group">
                <label>Frequenza Sincronizzazione</label>
                <select name="immens_sync_frequency" class="immens-select">
                    <option value="hourly" <?php selected('hourly', get_option('immens_sync_frequency', 'daily')) ?>>Ogni Ora</option>
                    <option value="twicedaily" <?php selected('twicedaily', get_option('immens_sync_frequency', 'daily')) ?>>Due Volte al Giorno</option>
                    <option value="daily" <?php selected('daily', get_option('immens_sync_frequency', 'daily')) ?>>Quotidiana</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="immens_auto_sync" 
                        <?php checked(1, get_option('immens_auto_sync', 1)) ?> value="1">
                    Abilita sincronizzazione automatica
                </label>
            </div>
            
            
            <?php submit_button('Salva Impostazioni'); ?>
        </form>
        
        <div class="sync-actions">
            <h3>Azioni Manuali</h3>
            <button id="force-full-sync" class="immens-btn">Sincronizzazione Completa</button>
            <button id="sync-client-data" class="immens-btn">Sinc. Dati Clienti</button>
            <button id="sync-requests" class="immens-btn">Sinc. Richieste</button>
        </div>
    </div>
</div>
