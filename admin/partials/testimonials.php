<?php
$user_testimonials = [
    [
        'phase' => 'pre',
        'date' => '10/04/2023',
        'feedback' => 'Grazie ai loro consigli ho completamente rivoluzionato la mia strategia...',
        'reward' => 50
    ],
    [
        'phase' => 'post',
        'date' => '15/05/2023',
        'feedback' => 'Dopo la consulenza abbiamo visto un incremento del 40% dei contatti...',
        'reward' => 75
    ]
];

$community_testimonials = [
    [
        'name' => 'Marco Rossi',
        'company' => 'Ristorante La Piazza',
        'feedback' => 'Il servizio di ottimizzazione SEO ha triplicato le nostre prenotazioni online in 3 mesi!',
        'results' => '+200% prenotazioni online'
    ],
    [
        'name' => 'Giulia Bianchi',
        'company' => 'Boutique Elegance',
        'feedback' => 'La campagna email marketing ha generato un ROI del 350% nel primo mese.',
        'results' => 'ROI 350%'
    ],
    [
        'name' => 'Luca Verdi',
        'company' => 'TecnoService',
        'feedback' => 'La landing page ottimizzata ha aumentato le conversioni dal 2% al 6.5% in due settimane.',
        'results' => '+225% conversioni'
    ]
];

$loyalty_points = get_user_meta(get_current_user_id(), 'immens_loyalty_points', true) ?: 120;
?>

<div class="immens-container">
    <div class="testimonials-columns">
        <!-- Left Column: Form Testimonianza -->
        <div class="testimonials-col">
            <div class="immens-card">
                <h2>Lascia la tua Testimonianza</h2>
                <div class="reward-notice">
                    Ottieni <strong>50 punti fedeltà</strong> per ogni testimonianza completa!
                </div>
                
                <div class="testimonial-wizard">
                    <!-- Step 1: Prima della collaborazione -->
                    <div class="wizard-step active" data-step="1">
                        <h3>Com'era la situazione prima di lavorare con noi?</h3>
                        <textarea name="before_situation" rows="4" placeholder="Descrivi le sfide che stavi affrontando..." class="immens-textarea"></textarea>
                    </div>
                    
                    <!-- Step 2: Durante l'assistenza -->
                    <div class="wizard-step" data-step="2">
                        <h3>Qual è stato il momento più utile durante la collaborazione?</h3>
                        <textarea name="during_experience" rows="4" placeholder="Cosa ti è piaciuto di più del nostro approccio?" class="immens-textarea"></textarea>
                    </div>
                    
                    <!-- Step 3: Dopo i risultati -->
                    <div class="wizard-step" data-step="3">
                        <h3>Quali risultati concreti hai ottenuto?</h3>
                        <textarea name="after_results" rows="4" placeholder="Es: +30% di traffico, +25% di conversioni..." class="immens-textarea"></textarea>
                        
                        <div class="rating-system">
                            <span class="rating-label">Quanto ti abbiamo aiutato?</span>
                            <div class="star-rating" data-rating="0">
                                <?php for($i=1; $i<=10; $i++): ?>
                                    <span class="star" data-value="<?php echo $i; ?>">★</span>
                                <?php endfor; ?>
                            </div>
                        </div>
                        
                        <div class="authorization">
                            <label>
                                <input type="checkbox" name="publish_consent">
                                Autorizzo a utilizzare questa testimonianza sui vostri canali
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="wizard-nav">
                    <button class="immens-btn prev-step" disabled>Indietro</button>
                    <button class="immens-btn next-step">Avanti</button>
                    <button class="immens-btn submit-testimonial" disabled>Invia Testimonianza</button>
                </div>
            </div>
            
            <!-- Le tue Testimonianze -->
            <div class="immens-card">
                <h3>Le tue Testimonianze</h3>
                <div class="user-testimonials">
                    <?php foreach ($user_testimonials as $testimonial): ?>
                        <div class="testimonial-item">
                            <div class="testimonial-header">
                                <span class="phase-badge <?php echo esc_attr($testimonial['phase']); ?>">
                                    <?php echo ($testimonial['phase'] === 'pre') ? 'Prima' : 'Dopo'; ?>
                                </span>
                                <span class="testimonial-date"><?php echo esc_html($testimonial['date']); ?></span>
                                <span class="testimonial-reward">+<?php echo (int)$testimonial['reward']; ?> pts</span>
                            </div>
                            <p>"<?php echo esc_html($testimonial['feedback']); ?>"</p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Right Column: Testimonianze Community -->
        <div class="testimonials-col">
            <div class="immens-card">
                <h2>Storie di Successo</h2>
                <p>Guarda come altri clienti hanno ottenuto risultati eccezionali</p>
                
                <div class="community-testimonials">
                    <?php foreach ($community_testimonials as $testimonial): ?>
                        <div class="testimonial-card">
                            <div class="testimonial-meta">
                                <div class="client-info">
                                    <strong><?php echo esc_html($testimonial['name']); ?></strong>
                                    <span><?php echo esc_html($testimonial['company']); ?></span>
                                </div>
                                <div class="testimonial-results">
                                    <?php echo esc_html($testimonial['results']); ?>
                                </div>
                            </div>
                            <blockquote>"<?php echo esc_html($testimonial['feedback']); ?>"</blockquote>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Reward Status -->
            <div class="immens-card">
                <h3>Il tuo Stato Reward</h3>
                <div class="loyalty-status">
                    <div class="loyalty-level">
                        <span class="level-label">Livello Attuale</span>
                        <span class="level-value"><?php echo floor($loyalty_points/100) + 1; ?></span>
                    </div>
                    <div class="loyalty-progress">
                        <div class="progress-bar" style="width: <?php echo ($loyalty_points % 100); ?>%"></div>
                        <div class="progress-labels">
                            <span>0</span>
                            <span>100</span>
                            <span>200</span>
                            <span>300</span>
                        </div>
                    </div>
                    <div class="loyalty-points">
                        <strong><?php echo (int)$loyalty_points; ?></strong> punti fedeltà
                    </div>
                </div>
                
                <div class="rewards-list">
                    <h4>Prossimi Reward:</h4>
                    <ul>
                        <li>
                            <span class="reward-points">300 pts</span>
                            <span class="reward-name">Guida SEO Avanzata</span>
                        </li>
                        <li>
                            <span class="reward-points">500 pts</span>
                            <span class="reward-name">Sconto 15% su tutti i servizi</span>
                        </li>
                        <li>
                            <span class="reward-points">1000 pts</span>
                            <span class="reward-name">Consulenza Strategica Gratuita</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>