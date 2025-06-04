<?php
$articles = [
    [
        'id' => 1,
        'title' => '5 Strategie di Direct Response per Triplicare le Conversioni',
        'content' => '<p>Il direct response marketing è focalizzato su un unico obiettivo: generare una risposta immediata...</p>
        <h3>1. L\'offerta Irresistibile</h3>
        <p>Un\'offerta ben strutturata deve contenere tre elementi fondamentali...</p>
        <h3>2. Urgenza e Scarsità</h3>
        <p>Limita l\'offerta nel tempo o nella quantità per spingere all\'azione immediata...</p>',
        'read_time' => 8,
        'category' => 'Marketing'
    ],
    [
        'id' => 2,
        'title' => 'Come Creare una Landing Page che Converte al 10%',
        'content' => '<p>Le landing page sono il cuore di qualsiasi campagna di direct response...</p>',
        'read_time' => 12,
        'category' => 'Conversion'
    ]
];

$ideas = [
    [
        'title' => 'Campagna a Scalare per Servizi Professionali',
        'description' => 'Strategia a 4 fasi per generare lead costanti per studi professionali',
        'steps' => ['Lead Magnet', 'Email Sequence', 'Webinar', 'Offerta Personalizzata']
    ],
    [
        'title' => 'Funnel di Vendita per E-commerce',
        'description' => 'Funnel completo da traffico a cliente ripetuto per negozi online',
        'steps' => ['Traffico a Pagamento', 'Pagina di Squeeze', 'Email di Benvenuto', 'Offerta Triangolo']
    ]
];

$resources = [
    [
        'type' => 'pdf',
        'title' => 'Guida Definitiva a WordPress per Business',
        'description' => 'Tutto ciò che devi sapere per gestire un sito WordPress professionale',
        'downloads' => 142
    ],
    [
        'type' => 'video',
        'title' => 'Masterclass SEO per WordPress',
        'description' => '3 ore di training avanzato su ottimizzazione SEO tecnica e contenuti',
        'duration' => '3h 15m'
    ],
    [
        'type' => 'checklist',
        'title' => 'Checklist Ottimizzazione Sito',
        'description' => 'Passo-passo per ottimizzare completamente il tuo sito WordPress',
        'steps' => 24
    ]
];
?>

<div class="immens-container">
    <div class="immens-card">
        <h2>Valore Continuo</h2>
        
        <div class="tabs">
            <button class="tab-link active" data-tab="articles">Articoli</button>
            <button class="tab-link" data-tab="ideas">Idee Strategiche</button>
            <button class="tab-link" data-tab="resources">Risorse</button>
        </div>
        
        <!-- ARTICLES TAB -->
        <div id="articles" class="tab-content active">
            <div class="articles-grid">
                <?php foreach ($articles as $article): ?>
                    <div class="article-card" data-article-id="<?php echo (int)$article['id']; ?>">
                        <div class="article-header">
                            <span class="article-category"><?php echo esc_html($article['category']); ?></span>
                            <span class="article-time"><?php echo (int)$article['read_time']; ?> min</span>
                        </div>
                        <h3><?php echo esc_html($article['title']); ?></h3>
                        <div class="article-excerpt">
                            <?php echo wp_kses_post($article['content']); ?>
                        </div>
                        <button class="immens-btn read-more">Leggi tutto</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- IDEAS TAB -->
        <div id="ideas" class="tab-content">
            <div class="ideas-header">
                <h3>Strategie di Direct Response Collaudate</h3>
                <p>Idee pronte all'uso per campagne marketing ad alta conversione</p>
            </div>
            
            <div class="strategy-grid">
                <?php foreach ($ideas as $idea): ?>
                    <div class="strategy-card">
                        <h4><?php echo esc_html($idea['title']); ?></h4>
                        <p><?php echo esc_html($idea['description']); ?></p>
                        <div class="strategy-steps">
                            <?php foreach ($idea['steps'] as $index => $step): ?>
                                <div class="strategy-step">
                                    <span class="step-number"><?php echo $index + 1; ?></span>
                                    <span class="step-name"><?php echo esc_html($step); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="immens-btn">Implementa questa strategia</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- RESOURCES TAB -->
        <div id="resources" class="tab-content">
            <div class="resources-header">
                <h3>Risorse Esclusive</h3>
                <p>Guide pratiche per massimizzare i risultati con il tuo sito WordPress</p>
            </div>
            
            <div class="resources-grid">
                <?php foreach ($resources as $resource): ?>
                    <div class="resource-card resource-<?php echo esc_attr($resource['type']); ?>">
                        <div class="resource-icon">
                            <?php if ($resource['type'] === 'pdf'): ?>
                                <span class="dashicons dashicons-pdf"></span>
                            <?php elseif ($resource['type'] === 'video'): ?>
                                <span class="dashicons dashicons-video-alt3"></span>
                            <?php else: ?>
                                <span class="dashicons dashicons-yes"></span>
                            <?php endif; ?>
                        </div>
                        <div class="resource-content">
                            <h4><?php echo esc_html($resource['title']); ?></h4>
                            <p><?php echo esc_html($resource['description']); ?></p>
                            <div class="resource-meta">
                                <?php if ($resource['type'] === 'pdf'): ?>
                                    <span class="dashicons dashicons-download"></span>
                                    <?php echo (int)$resource['downloads']; ?> download
                                <?php elseif ($resource['type'] === 'video'): ?>
                                    <span class="dashicons dashicons-clock"></span>
                                    <?php echo esc_html($resource['duration']); ?>
                                <?php else: ?>
                                    <span class="dashicons dashicons-list-view"></span>
                                    <?php echo (int)$resource['steps']; ?> passi
                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="#" class="immens-btn">Scarica</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>