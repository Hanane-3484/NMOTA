<?php

function add_scripts() {
    // Enregistrer le fichier JavaScript
    wp_enqueue_script('mes-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'add_scripts');

function add_styles() {
    wp_enqueue_style('mon-style', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
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

