<div class="photo-item">
    <div class="image-container">
        <?php
        if (has_post_thumbnail()) {
            the_post_thumbnail('medium'); // Affiche l'image à la une
        } else {
            echo '<img src="' . get_template_directory_uri() . '/Assets/Medias/default-photo.jpg" alt="Image par défaut">';
        }
        ?>
        <!-- Icônes -->
        <div class="icons">
            <a href="<?php the_permalink(); ?>">
                <img class="eye" src="<?php echo get_template_directory_uri(); ?>/Assets/Medias/eye.png" alt="Voir">
            </a>
            <div class="popup">
            <img 
                class="fullscreen" 
                src="<?php echo get_template_directory_uri(); ?>/Assets/Medias/fullscreen.png" 
                alt="Agrandir"
                data-image="<?php echo get_the_post_thumbnail_url(); ?>" 
                data-title="<?php the_title(); ?>" 
                data-categories="<?php echo implode(', ', wp_list_pluck(get_the_terms(get_the_ID(), 'categorie'), 'name')); ?>" 
            >
    </div>
        </div>
    </div>
    
    <!-- Informations supplémentaires -->
    <div class="info">
        <div class="title">
            <span class="title-lightbox"><?php the_title(); ?></span>
        </div>
        <div class="category">
            <?php
            $categories = get_the_terms(get_the_ID(), 'categorie');
            if ($categories && !is_wp_error($categories)) :
                echo '<span class="category-lightbox">';
                $category_list = array();
                foreach ($categories as $category) {
                    $category_list[] = esc_html($category->name);
                }
                echo implode(', ', $category_list);
                echo '</span>';
            endif;
            ?>
        </div>
    </div>
</div>