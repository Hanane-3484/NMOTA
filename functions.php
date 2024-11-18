<?php

function add_scripts() {
    // Enregistrer le fichier JavaScript
    wp_enqueue_script( 'mon-script', get_stylesheet_directory_uri() . '/js/script.js', array(), '1.0.0', true );
    wp_enqueue_script('script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'add_scripts');

function add_styles() {
    // Enregistrer le fichier CSS
    wp_enqueue_style( 'mon-style', get_stylesheet_directory_uri() . '/style.css', array(), '1.0', 'all' );
}
add_action('wp_enqueue_scripts', 'add_styles');

function register_my_menu() {
    register_nav_menus(
        array(
            'header-menu' => __( 'Header Menu' ),
            'footer-menu' => __( 'Footer Menu' )
        )
    );
    }
add_action( 'init', 'register_my_menu' );

function ajouter_id_au_menu($items) {
    foreach ($items as $item) {
        if ($item->title == 'CONTACT') { 
            $item->attr_title = 'contact';
        }
    }
    return $items;
}
add_filter('wp_nav_menu_objects', 'ajouter_id_au_menu');