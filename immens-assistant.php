<?php
/**
 * Plugin Name: Immens Assistant
 * Description: Assistente completo per la gestione dei servizi digitali
 * Version: 1.0.1
 * Author: Studio Immens
 * Text Domain: immens-assistant
 * Domain Path: /languages
 * License: GPL v2 or later
 */

defined('ABSPATH') or die('No script kiddies please!');

// Definisci costanti
define('IMMENS_VERSION', '1.0.1');
define('IMMENS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('IMMENS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Carica file principali
require_once IMMENS_PLUGIN_DIR . 'includes/class-database.php';
require_once IMMENS_PLUGIN_DIR . 'admin/class-immens-admin.php';

// Registra attivazione/disattivazione
register_activation_hook(__FILE__, ['Immens_Database', 'activate']);
register_deactivation_hook(__FILE__, ['Immens_Database', 'deactivate']);

// Inizializzazione
add_action('plugins_loaded', 'init_immens_assistant');
function init_immens_assistant() {
    Immens_Database::init();
    Immens_Admin::init();
}



























// 1. Funzionalità SEO
function calculate_seo_score($post_id) {
    $score = 100;
    $issues = [];
    $post = get_post($post_id);
    $content = strip_tags($post->post_content);
    
    // Controllo titolo
    $title = get_the_title($post_id);
    if(empty($title)) {
        $score -= 15;
        $issues[] = 'Titolo mancante';
    } elseif(mb_strlen($title) > 60) {
        $score -= 5;
        $issues[] = 'Titolo troppo lungo';
    }
    
    // Controllo contenuto
    $word_count = str_word_count($content);
    if($word_count < 300) {
        $score -= 10;
        $issues[] = 'Contenuto troppo breve';
    }
    
    // Controllo meta description
    $meta = get_post_meta($post_id, '_yoast_wpseo_metadesc', true);
    if(empty($meta)) {
        $score -= 10;
        $issues[] = 'Meta description mancante';
    } elseif(mb_strlen($meta) > 160) {
        $score -= 5;
        $issues[] = 'Meta description troppo lunga';
    }
    
    // Controllo immagini (alt text)
    $images = get_attached_media('image', $post_id);
    $images_without_alt = 0;
    foreach($images as $image) {
        if(empty($image->alt)) $images_without_alt++;
    }
    if($images_without_alt > 0) {
        $score -= min(10, $images_without_alt * 2);
        $issues[] = "$images_without_alt immagini senza alt text";
    }
    
    // Controllo headings
    if(!preg_match('/<h[1-6].*?>/', $post->post_content)) {
        $score -= 10;
        $issues[] = 'Nessun tag heading utilizzato';
    }
    
    return [
        'score' => max(0, $score),
        'issues' => $issues
    ];
}

// 2. Funzionalità Velocità
function calculate_speed_score() {
    $score = 80;
    $issues = [];
    
    // Controllo caching
    if(!wp_using_ext_object_cache()) {
        $score -= 10;
        $issues[] = 'Object cache non attivo';
    }
    
    // Controllo compressione
    if(!extension_loaded('zlib')) {
        $score -= 5;
        $issues[] = 'Compressione GZIP non attiva';
    }
    
    // Controllo CDN
    $home_url = home_url();
    if(strpos($home_url, 'cdn') === false) {
        $score -= 5;
        $issues[] = 'CDN non configurato';
    }
    
    return [
        'score' => max(0, $score),
        'issues' => $issues
    ];
}

// 3. Funzionalità Sicurezza
function calculate_security_score() {
    $score = 85;
    $issues = [];
    
    // Controllo HTTPS
    if(!is_ssl()) {
        $score -= 15;
        $issues[] = 'Sito non in HTTPS';
    }
    
    // Controllo versione PHP
    if(version_compare(PHP_VERSION, '7.4', '<')) {
        $score -= 10;
        $issues[] = 'Versione PHP obsoleta';
    }
    
    // Controllo aggiornamenti WordPress
    if(get_core_updates()) {
        $score -= 5;
        $issues[] = 'Aggiornamenti WordPress disponibili';
    }
    
    return [
        'score' => max(0, $score),
        'issues' => $issues
    ];
}

// Interfaccia Admin
function spa_admin_menu() {
    add_menu_page(
        'Site Analyzer',
        'Site Performance',
        'manage_options',
        'site-analyzer',
        'spa_admin_page',
        'dashicons-dashboard'
    );
}
add_action('admin_menu', 'spa_admin_menu');

function spa_admin_page() {
    ?>
    <div class="wrap">
        <h1>Site Performance Analyzer</h1>
        
        <div class="tabs">
            <button class="tablink active" data-tab="seo">SEO</button>
            <button class="tablink" data-tab="speed">Velocità</button>
            <button class="tablink" data-tab="security">Sicurezza</button>
        </div>
        
        <div id="seo" class="tabcontent active">
            <h2>Analisi SEO</h2>
            <div id="overall-seo-score" class="score-container"></div>
            <div id="seo-results"></div>
        </div>
        
        <div id="speed" class="tabcontent">
            <h2>Analisi Velocità</h2>
            <div id="speed-score" class="score-container"></div>
            <ul id="speed-issues"></ul>
        </div>
        
        <div id="security" class="tabcontent">
            <h2>Analisi Sicurezza</h2>
            <div id="security-score" class="score-container"></div>
            <ul id="security-issues"></ul>
        </div>
    </div>
    
    <style>
        .score-container {
            font-size: 2em;
            margin: 20px 0;
            padding: 20px;
            background: #f5f5f5;
            border-radius: 5px;
            text-align: center;
        }
        .tabcontent { display: none; }
        .tabcontent.active { display: block; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        .good { color: green; }
        .medium { color: orange; }
        .bad { color: red; }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        $('.tablink').click(function() {
            $('.tabcontent').removeClass('active');
            $('.tablink').removeClass('active');
            $(this).addClass('active');
            $('#' + $(this).data('tab')).addClass('active');
        });
        
        // Carica dati SEO
        $.post(ajaxurl, {action: 'get_seo_data'}, function(response) {
            if(response.success) {
                $('#overall-seo-score').html(
                    `<h3>Punteggio SEO Globale: 
                    <span class="${getScoreClass(response.overall)}">${response.overall}%</span>
                    </h3>`
                );
                
                let table = `<table>
                    <tr><th>Titolo</th><th>Tipo</th><th>Punteggio</th><th>Problemi</th></tr>`;
                
                response.data.forEach(post => {
                    table += `<tr>
                        <td><a href="${post.link}" target="_blank">${post.title}</a></td>
                        <td>${post.type}</td>
                        <td class="${getScoreClass(post.score)}">${post.score}%</td>
                        <td>${post.issues.join(', ') || 'Nessun problema'}</td>
                    </tr>`;
                });
                
                table += '</table>';
                $('#seo-results').html(table);
            }
        });
        
        // Carica dati velocità
        $.post(ajaxurl, {action: 'get_speed_data'}, function(response) {
            if(response.success) {
                $('#speed-score').html(
                    `<h3>Punteggio Velocità: 
                    <span class="${getScoreClass(response.score)}">${response.score}%</span>
                    </h3>`
                );
                
                let issues = '';
                response.issues.forEach(issue => {
                    issues += `<li>${issue}</li>`;
                });
                $('#speed-issues').html(issues || '<li>Nessun problema rilevato</li>');
            }
        });
        
        // Carica dati sicurezza
        $.post(ajaxurl, {action: 'get_security_data'}, function(response) {
            if(response.success) {
                $('#security-score').html(
                    `<h3>Punteggio Sicurezza: 
                    <span class="${getScoreClass(response.score)}">${response.score}%</span>
                    </h3>`
                );
                
                let issues = '';
                response.issues.forEach(issue => {
                    issues += `<li>${issue}</li>`;
                });
                $('#security-issues').html(issues || '<li>Nessun problema rilevato</li>');
            }
        });
        
        function getScoreClass(score) {
            if(score >= 80) return 'good';
            if(score >= 50) return 'medium';
            return 'bad';
        }
    });
    </script>
    <?php
}

// AJAX Handlers
add_action('wp_ajax_get_seo_data', 'spa_get_seo_data');
function spa_get_seo_data() {
    $posts = get_posts(['numberposts' => -1, 'post_type' => ['post', 'page']]);
    $total_score = 0;
    $results = [];
    
    foreach($posts as $post) {
        $seo = calculate_seo_score($post->ID);
        $total_score += $seo['score'];
        
        $results[] = [
            'title' => $post->post_title,
            'type' => get_post_type($post->ID),
            'score' => $seo['score'],
            'issues' => $seo['issues'],
            'link' => get_permalink($post->ID)
        ];
    }
    
    wp_send_json_success([
        'overall' => count($posts) ? round($total_score / count($posts)) : 0,
        'data' => $results
    ]);
}

add_action('wp_ajax_get_speed_data', 'spa_get_speed_data');
function spa_get_speed_data() {
    $speed = calculate_speed_score();
    wp_send_json_success([
        'score' => $speed['score'],
        'issues' => $speed['issues']
    ]);
}

add_action('wp_ajax_get_security_data', 'spa_get_security_data');
function spa_get_security_data() {
    $security = calculate_security_score();
    wp_send_json_success([
        'score' => $security['score'],
        'issues' => $security['issues']
    ]);
}