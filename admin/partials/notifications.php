<?php
$notifications = [
    [
        'id' => 1,
        'type' => 'strategic',
        'title' => 'Nuova strategia per il Black Friday',
        'content' => 'Scarica la guida per massimizzare le vendite nel periodo natalizio',
        'date' => '2 ore fa',
        'unread' => true,
        'action' => ['label' => 'Scarica Guida', 'url' => '#']
    ],
    [
        'id' => 2,
        'type' => 'technical',
        'title' => 'Aggiornamento plugin SEO disponibile',
        'content' => 'La versione 5.3 del tuo plugin SEO include importanti miglioramenti',
        'date' => '1 giorno fa',
        'unread' => false,
        'action' => ['label' => 'Aggiorna', 'url' => '#']
    ],
    [
        'id' => 3,
        'type' => 'commercial',
        'title' => 'Offerta speciale su pacchetti SEO',
        'content' => 'Fino al 30% di sconto sui pacchetti SEO premium solo questa settimana',
        'date' => '3 giorni fa',
        'unread' => true,
        'action' => ['label' => 'Scopri', 'url' => '#']
    ]
];

$admin_bar_enabled = get_user_meta(get_current_user_id(), 'immens_adminbar_notifications', true) ?: 'yes';
?>

<div class="immens-container">
    <div class="notifications-header">
        <h2>Notifiche</h2>
        <div class="notifications-settings">
            <label>
                <input type="checkbox" id="adminbar-notifications" <?php checked($admin_bar_enabled, 'yes'); ?>>
                Mostra notifiche nella Admin Bar
            </label>
            <button id="mark-all-read" class="immens-btn">Segna tutte come lette</button>
        </div>
    </div>
    
    <div class="notification-filters">
        <button data-category="all" class="active">Tutte</button>
        <button data-category="strategic">Strategiche</button>
        <button data-category="technical">Tecniche</button>
        <button data-category="commercial">Commerciali</button>
    </div>
    
    <div class="notifications-container">
        <div class="notification-list">
            <?php foreach ($notifications as $notification): ?>
                <div class="notification-item <?php echo ($notification['unread']) ? 'unread' : ''; ?>" 
                     data-type="<?php echo esc_attr($notification['type']); ?>"
                     data-id="<?php echo (int)$notification['id']; ?>">
                    <?php if ($notification['unread']): ?>
                        <span class="notification-badge">Nuova</span>
                    <?php endif; ?>
                    <h3><?php echo esc_html($notification['title']); ?></h3>
                    <p><?php echo esc_html($notification['content']); ?></p>
                    <div class="notification-meta">
                        <span class="notification-date"><?php echo esc_html($notification['date']); ?></span>
                        <div class="notification-actions">
                            <?php if (!empty($notification['action'])): ?>
                                <a href="<?php echo esc_url($notification['action']['url']); ?>" class="immens-btn small">
                                    <?php echo esc_html($notification['action']['label']); ?>
                                </a>
                            <?php endif; ?>
                            <button class="notification-dismiss">Segna come letta</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>