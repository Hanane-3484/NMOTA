<?php

function add_scripts() {
    // Enregistre le fichier JavaScript
    wp_enqueue_script( 'mon-script', get_stylesheet_directory_uri() . '/js/script.js', array(), '1.0.0', true );
    wp_enqueue_script('script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'add_scripts');

function add_styles() {
    // Enregistre le fichier CSS
    wp_enqueue_style( 'mon-style', get_stylesheet_directory_uri() . '/style.css', array(), '1.0', 'all' );
}
add_action('wp_enqueue_scripts', 'add_styles');

    // Enregistre le menu Wordpress
function register_my_menu() {
    register_nav_menus(
        array(
            'header-menu' => __( 'Header Menu' ),
            'footer-menu' => __( 'Footer Menu' )
        )
    );
    }


add_action( 'init', 'register_my_menu' );

    // Crée l'id Contact au menu Wordpress 
function ajouter_id_au_menu($items) {
    foreach ($items as $item) {
        if ($item->title == 'CONTACT') { 
            $item->attr_title = 'contact-menu';
        }
    }
    return $items;
}
add_filter('wp_nav_menu_objects', 'ajouter_id_au_menu');


    // Enregistre la requête AJAX pour la Grid Photo
    function enqueue_my_ajax_script() {
        wp_enqueue_script('ajax-grid', get_template_directory_uri() . '/js/ajax-grid.js', array('jquery'), null, true);
    
        // Localisation des paramètres nécessaires pour AJAX
        wp_localize_script('ajax-grid', 'ajaxData', array(
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('load_photo_grid_nonce') // Nonce pour sécuriser les requêtes
        ));
    }
    add_action('wp_enqueue_scripts', 'enqueue_my_ajax_script');

// Fonction qui charge la grille de photos via Ajax
function load_photo_grid() {
    // Vérification de sécurité
    check_ajax_referer('load_photo_grid_nonce', 'nonce');

    // Récupération des paramètres AJAX
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 8;
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $order = isset($_POST['order']) ? strtoupper(sanitize_text_field($_POST['order'])) : 'DESC';

    // Arguments de base pour la requête WordPress
    $args = array(
        'post_type'      => 'photo', // Assurez-vous que 'photo' est bien votre type de contenu personnalisé
        'posts_per_page' => $posts_per_page,
        'orderby'        => 'date',
        'order'          => $order, // Par défaut 'DESC' pour les plus récentes
        'offset'         => $offset,
    );

    // Ajouter un filtre par catégorie si défini
    if ($category) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }

    // Ajouter un filtre par format si défini
    if ($format) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    // Exécution de la requête WP_Query
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            // Inclure le template part pour chaque photo
            get_template_part('templates_part/photo-block');
        endwhile;
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;

    // Réinitialisation des données post
    wp_reset_postdata();
    wp_die(); // Terminer proprement la requête AJAX
}

// Actions AJAX pour les utilisateurs connectés et non connectés
add_action('wp_ajax_load_photo_grid', 'load_photo_grid');
add_action('wp_ajax_nopriv_load_photo_grid', 'load_photo_grid');