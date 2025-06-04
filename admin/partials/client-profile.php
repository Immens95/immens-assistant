<?php
$digital_level = 65; // Esempio
$loyalty_points = 450; // Esempio
$completed_missions = 3; // Esempio
$total_missions = 8; // Esempio
$is_vip = ($loyalty_points > 400); // Esempio
?>

<div class="immens-container">
    <div class="client-dashboard">
        <div class="client-stats">
            <div class="stat-card">
                <h4>Livello di digitalizzazione</h4>
                <div class="digital-level">
                    <div class="level-bar" style="width: <?php echo (int)$digital_level; ?>%"></div>
                </div>
                <button class="immens-btn update-level">Aggiorna livello</button>
            </div>
            
            <div class="stat-card">
                <h4>Punti Fedeltà</h4>
                <div class="loyalty-points"><?php echo (int)$loyalty_points; ?></div>
                <div class="loyalty-rewards">
                    <p>Ricompense disponibili:</p>
                    <ul>
                        <li>Sconto 10% sul prossimo servizio</li>
                        <li>Guida SEO avanzata</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="client-objectives">
            <h3>I tuoi obiettivi principali</h3>
            <ul class="objectives-list">
                <li>Aumentare le conversioni del sito</li>
                <li>Migliorare il posizionamento SEO</li>
                <li>Implementare un sistema di newsletter</li>
            </ul>
            <button class="immens-btn add-objective">+ Aggiungi obiettivo</button>
        </div>
        
        <?php if ($is_vip): ?>
        <div class="vip-section">
            <button class="immens-btn vip-cta">Prenota call con stratega</button>
            <div class="vip-perks">
                <h4>Benefici VIP:</h4>
                <ul>
                    <li>Supporto prioritario 24/7</li>
                    <li>Sconti esclusivi su tutti i servizi</li>
                    <li>Consulenze strategiche mensili</li>
                </ul>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="strategic-missions">
        <h2>La tua Missione Strategica</h2>
        <div class="missions-progress">
            <div class="mission-badge"><?php echo (int)$completed_missions; ?>/<?php echo (int)$total_missions; ?></div>
            <div class="missions-list">
                <div class="mission completed">
                    <span class="mission-check">✓</span>
                    <span class="mission-title">Ottimizzazione Homepage</span>
                </div>
                <div class="mission completed">
                    <span class="mission-check">✓</span>
                    <span class="mission-title">Primo articolo SEO</span>
                </div>
                <div class="mission in-progress">
                    <span class="mission-check">•</span>
                    <span class="mission-title">Configurazione Google Analytics</span>
                </div>
            </div>
        </div>
        
        <div class="mission-rewards">
            <h3>Ricompense in attesa:</h3>
            <ul>
                <li>Guida avanzata SEO (completa 5 missioni)</li>
                <li>Sconto 15% su tutti i servizi (completa 8 missioni)</li>
            </ul>
        </div>
    </div>
</div>