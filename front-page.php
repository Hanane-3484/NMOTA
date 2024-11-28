<?php get_header(); ?>

<!-- Section Hero -->
<?php
$args = array(
    'post_type'      => 'photo', // Slug du CPT
    'posts_per_page' => 1,
    'orderby'        => 'rand' // Sélectionner un post aléatoire
);

$random_query = new WP_Query($args);

if ($random_query->have_posts()) :
    while ($random_query->have_posts()) : $random_query->the_post();
        $random_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    endwhile;
    wp_reset_postdata();
else :
    $random_image_url = get_template_directory_uri() . '/Assets/Medias/default-hero.jpg';
endif;
?>

<div class="hero">
    <img class="title-hero" src="<?php echo get_template_directory_uri(); ?>/Assets/Medias/title-hero.png" alt="Titre du hero">
    <img class="photo-hero" src="<?php echo esc_url($random_image_url); ?>" alt="Image aléatoire du hero">
</div>
<div class="container-grid">
<!-- Tri des photos selon catégories et/ou formats-->

<div class="sort">
    <div class="category-format">
        <!-- Dropdown pour les catégories -->
        <div class="custom-dropdown" id="custom-category">
            <div class="dropdown-trigger">
                CATEGORIES
                <span class="dropdown-arrow"></span>
            </div>
            <ul class="dropdown-options">
                <!-- Option pour toutes les catégories -->
                <li data-value="" class="all-categories">Toutes les catégories</li>
                <?php
                $categories = get_terms(array(
                    'taxonomy' => 'categorie',
                    'hide_empty' => false,
                ));
                foreach ($categories as $category) {
                    echo '<li data-value="' . $category->slug . '">' . $category->name . '</li>';
                }
                ?>
    
            </ul>
        </div>

        <!-- Dropdown pour les formats -->
        <div class="custom-dropdown" id="custom-format">
            <div class="dropdown-trigger">FORMATS
                <span class="dropdown-arrow"></span> <!-- Flèche ici -->
            </div>
            <ul class="dropdown-options">
                <!-- Option pour tous les formats -->
                <?php
                $formats = get_terms(array(
                    'taxonomy' => 'format',
                    'hide_empty' => false,
                ));
                foreach ($formats as $format) {
                    echo '<li data-value="' . $format->slug . '">' . $format->name . '</li>';
                }
                ?>
        
            </ul>
        </div>
    </div>

    <!-- Dropdown pour le tri -->
    <div class="custom-dropdown" id="custom-sort">
        <div class="dropdown-trigger">
            TRIER PAR
            <span class="dropdown-arrow"></span>
        </div>
        <ul class="dropdown-options">
            <li class="order">Ordre</li>
            <li data-value="date_desc">À partir des plus récentes</li> 
            <li data-value="date_asc">À partir des plus anciennes</li>
        </ul>
    </div>
</div>
    
<!-- Grid des photos -->
<div class="photo-grid">
</div>
<button id="load-more">Charger plus</button>
</div>
        </div>

<?php get_footer(); ?>