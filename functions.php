<?php

function add_scripts() {
// Enregistre le fichier JavaScript
    wp_enqueue_script('script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);
    wp_enqueue_script( 'filters', get_stylesheet_directory_uri() . '/js/filters.js', array(), '1.0.0', true);
    wp_enqueue_script( 'menuburger', get_stylesheet_directory_uri() . '/js/menu-burger.js', array(), '1.0.0', true);}
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
    // Charge jQuery
    wp_enqueue_script('jquery'); // Ajoute la bibliothèque jQuery à la page

    // Charge jQuery Migrate si nécessaire
    wp_enqueue_script('jquery-migrate'); // Ajoute jQuery Migrate si une version ancienne de jQuery est utilisée

    // Charge 'lightbox.js' et 'ajax-grid.js'
    wp_enqueue_script('lightbox', get_template_directory_uri() . '/js/lightbox.js', array('jquery'), '1.0.0', true); 
    // Charge le script 'lightbox.js' en s'assurant qu'il dépend de jQuery. Le fichier est placé dans le répertoire du thème.
    
    wp_enqueue_script('ajax-grid', get_template_directory_uri() . '/js/ajax-grid.js', array('jquery', 'lightbox'), '1.0.0', true); 
    // Charge le script 'ajax-grid.js', qui dépend à la fois de jQuery et de lightbox.js.

    // Localisation de données JavaScript pour l'usage dans ajax-grid.js
    wp_localize_script('ajax-grid', 'ajaxData', array(
        'url' => admin_url('admin-ajax.php'), // URL pour effectuer la requête AJAX dans WordPress
        'nonce' => wp_create_nonce('load_photo_grid_nonce') // Crée un nonce pour la sécurité AJAX
    ));
}

// Attache la fonction enqueue_my_ajax_script à l'action 'wp_enqueue_scripts' pour que le script soit chargé sur le site
add_action('wp_enqueue_scripts', 'enqueue_my_ajax_script');

// Fonction qui charge la grille de photos via Ajax
function load_photo_grid() {
    // Vérification de sécurité avec nonce
    check_ajax_referer('load_photo_grid_nonce', 'nonce'); // Assure que la requête AJAX est légitime

    // Récupération des paramètres envoyés avec la requête AJAX
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 8; // Nombre de photos à afficher
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0; // Décalage pour les photos déjà chargées
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : ''; // Catégorie sélectionnée
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : ''; // Format sélectionné
    $order = isset($_POST['order']) ? strtoupper(sanitize_text_field($_POST['order'])) : 'DESC'; // Ordre de tri (ASC ou DESC)

    // Arguments de base pour la requête WordPress
    $args = array(
        'post_type'      => 'photo', // Type de contenu personnalisé, ici 'photo'
        'posts_per_page' => $posts_per_page, // Nombre de photos à charger
        'orderby'        => 'date', // Tri par date
        'order'          => $order, // Ordre de tri (DESC ou ASC)
        'offset'         => $offset, // Décalage
    );

    // Ajoute un filtre par catégorie si une catégorie est définie
    if ($category) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie', // Taxonomie pour la catégorie
            'field'    => 'slug', // Utilise le slug pour la recherche
            'terms'    => $category, // La catégorie à filtrer
        );
    }

    // Ajoute un filtre par format si un format est défini
    if ($format) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format', // Taxonomie pour le format
            'field'    => 'slug', // Utiliser le slug pour la recherche
            'terms'    => $format, // Le format à filtrer
        );
    }

    // Exécution de la requête WP_Query avec les arguments définis
    $query = new WP_Query($args); // Exécute la requête pour récupérer les photos selon les critères

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); // Si des posts sont trouvés
            // Inclure le template part pour chaque photo
            get_template_part('templates_part/photo-block'); // Charge le modèle de photo
        endwhile;
    else :
        echo '';// Message affiché s'il n'y a aucune photo correspondante
    endif;

    // Réinitialisation des données post pour éviter tout conflit
    wp_reset_postdata(); // Réinitialise la boucle WordPress

    wp_die(); // Termine proprement la requête AJAX, WordPress attend cette fonction
}

// Actions AJAX pour les utilisateurs connectés et non connectés
add_action('wp_ajax_load_photo_grid', 'load_photo_grid'); // Pour les utilisateurs connectés
add_action('wp_ajax_nopriv_load_photo_grid', 'load_photo_grid'); // Pour les utilisateurs non connectés

?>