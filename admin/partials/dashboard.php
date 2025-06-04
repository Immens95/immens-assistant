<?php
$user_id = get_current_user_id();
$digital_level = get_user_meta($user_id, 'immens_digital_level', true) ?: 35;
$loyalty_points = get_user_meta($user_id, 'immens_loyalty_points', true) ?: 120;
$completed_missions = 3;
$total_missions = 8;

$stats = [
    'services_used' => 8,
    'leads_generated' => 24,
    'conversion_rate' => 18.7,
    'content_views' => 56
];

$missions = [
    ['title' => 'Ottimizza Homepage', 'progress' => 100, 'reward' => 50],
    ['title' => 'Configura Google Analytics', 'progress' => 75, 'reward' => 75],
    ['title' => 'Crea 5 articoli SEO', 'progress' => 40, 'reward' => 150]
];

$site_health = [
    'seo_score' => 68,
    'speed_score' => 54,
    'security_score' => 92
];
?>

<div class="immens-container">
    <!-- Hero Welcome -->
    <div class="immens-card welcome-card">
        <div class="welcome-header">
            <h1>Benvenuto, <?php echo esc_html(wp_get_current_user()->display_name); ?>!</h1>
            <div class="loyalty-badge">
                <span class="points"><?php echo (int)$loyalty_points; ?> pts</span>
                <span>Livello <?php echo floor($loyalty_points/100) + 1; ?></span>
            </div>
        </div>
        <p class="subtitle">Ecco la tua situazione digitale aggiornata</p>
        
        <div class="digital-health">
            <div class="health-metric">
                <div class="gauge" data-value="<?php echo (int)$site_health['seo_score']; ?>">
                    <div class="gauge-fill"></div>
                    <span class="gauge-value"><?php echo (int)$site_health['seo_score']; ?>%</span>
                </div>
                <label>SEO Score</label>
            </div>
            
            <div class="health-metric">
                <div class="gauge" data-value="<?php echo (int)$site_health['speed_score']; ?>">
                    <div class="gauge-fill"></div>
                    <span class="gauge-value"><?php echo (int)$site_health['speed_score']; ?>%</span>
                </div>
                <label>Velocità</label>
            </div>
            
            <div class="health-metric">
                <div class="gauge" data-value="<?php echo (int)$site_health['security_score']; ?>">
                    <div class="gauge-fill"></div>
                    <span class="gauge-value"><?php echo (int)$site_health['security_score']; ?>%</span>
                </div>
                <label>Sicurezza</label>
            </div>
        </div>
    </div>
    
    <div class="dashboard-columns">
        <!-- Left Column -->
        <div class="dashboard-col">
            <!-- Missioni Attive -->
            <div class="immens-card">
                <h2>Le tue Missioni</h2>
                <div class="missions-list">
                    <?php foreach ($missions as $mission): ?>
                    <div class="mission-item">
                        <div class="mission-progress">
                            <div class="progress-bar" style="width: <?php echo (int)$mission['progress']; ?>%"></div>
                        </div>
                        <div class="mission-info">
                            <h3><?php echo esc_html($mission['title']); ?></h3>
                            <div class="mission-reward">+<?php echo (int)$mission['reward']; ?> pts</div>
                        </div>
                        <button class="immens-btn mission-action">Dettagli</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="missions-footer">
                    <div class="mission-stats">
                        Completate: <?php echo (int)$completed_missions; ?>/<?php echo (int)$total_missions; ?>
                    </div>
                    <button class="immens-btn">Vedi tutte le missioni</button>
                </div>
            </div>
            
            <!-- Statistiche Chiave -->
            <div class="immens-card">
                <h2>Le tue Performance</h2>
                <div class="performance-grid">
                    <div class="metric-card">
                        <div class="metric-value"><?php echo (int)$stats['services_used']; ?></div>
                        <div class="metric-label">Servizi Usati</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-value"><?php echo (int)$stats['leads_generated']; ?></div>
                        <div class="metric-label">Lead Generati</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-value"><?php echo (float)$stats['conversion_rate']; ?>%</div>
                        <div class="metric-label">Tasso Conversione</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-value"><?php echo (int)$stats['content_views']; ?></div>
                        <div class="metric-label">Contenuti Visti</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="dashboard-col">
            <!-- Notifiche Urgenti -->
            <div class="immens-card urgent-card">
                <h2>Avvisi Importanti</h2>
                <div class="alerts-list">
                    <div class="alert-item critical">
                        <div class="alert-icon">!</div>
                        <div class="alert-content">
                            <h3>Aggiornamento di Sicurezza Critico</h3>
                            <p>WordPress 6.2.1 risolve una vulnerabilità importante</p>
                        </div>
                        <button class="immens-btn">Applica</button>
                    </div>
                    <div class="alert-item warning">
                        <div class="alert-icon">!</div>
                        <div class="alert-content">
                            <h3>Backup non eseguito da 7 giorni</h3>
                            <p>Programma un backup completo del tuo sito</p>
                        </div>
                        <button class="immens-btn">Pianifica</button>
                    </div>
                </div>
            </div>
            
            <!-- Reward Disponibili -->
            <div class="immens-card rewards-card">
                <h2>Ricompense in Attesa</h2>
                <div class="rewards-grid">
                    <div class="reward-item">
                        <div class="reward-icon">🏆</div>
                        <div class="reward-content">
                            <h3>Guida SEO Avanzata</h3>
                            <p>Sbloccabile a 300 punti</p>
                        </div>
                        <div class="reward-progress">
                            <div class="progress" style="width: <?php echo min(100, ($loyalty_points/300)*100); ?>%"></div>
                        </div>
                    </div>
                    <div class="reward-item">
                        <div class="reward-icon">🎁</div>
                        <div class="reward-content">
                            <h3>Sconto 15% su tutti i servizi</h3>
                            <p>Sbloccabile a 500 punti</p>
                        </div>
                        <div class="reward-progress">
                            <div class="progress" style="width: <?php echo min(100, ($loyalty_points/500)*100); ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>