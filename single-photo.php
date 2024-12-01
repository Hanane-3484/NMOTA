<?php get_header(); ?>

<main id="main-content" class="site-main">
    <?php
    // Une boucle principale pour obtenir la photo actuellement visitée
    if (have_posts()) :
        while (have_posts()) : the_post();
            // Récupère la référence et autres métadonnées de la photo
            $reference = get_post_meta(get_the_ID(), 'reference', true);
            $categories = get_the_terms(get_the_ID(), 'categorie');
            $formats = get_the_terms(get_the_ID(), 'format');
            $type = get_post_meta(get_the_ID(), 'type', true);

            // Récupère la photo précédente et la suivante par date de publication
            $prev_post = get_previous_post();
            $next_post = get_next_post();
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <!-- Affiche la photo de l'article (image à la une) -->
                <div class="post-photo">
                    <div class="post-thumbnail">
                        <?php 
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('large');
                        }
                        ?>
                    </div>

                    <div class="description-post-thumbnail">
                        <h2 class="entry-title-photo"><?php the_title(); ?></h2>

                        <div class="entry-reference">
                            <?php 
                            if ($reference) {
                                echo '<span class="reference">RÉFÉRENCE : ' . esc_html($reference) . '</span>';
                            }
                            ?>
                        </div>

                        <div class="entry-categorie">
                            <?php
                            if ($categories && !is_wp_error($categories)) :
                                echo '<span class="categories">CATÉGORIE : ';
                                $category_list = array();
                                foreach ($categories as $category) {
                                    $category_list[] = esc_html($category->name);
                                }
                                echo implode(', ', $category_list);
                                echo '</span>';
                            endif;
                            ?>
                        </div>

                        <div class="entry-format">
                            <?php
                            if ($formats && !is_wp_error($formats)) :
                                echo '<span class="formats">FORMAT : ';
                                $format_list = array();
                                foreach ($formats as $format) {  
                                    $format_list[] = esc_html($format->name);
                                }
                                echo implode(', ', $format_list);
                                echo '</span>';
                            endif;
                            ?>
                        </div>

                        <div class="entry-type">
                            <?php 
                            if ($type) {
                                echo '<span class="type">TYPE : ' . esc_html($type) . '</span>';
                            }
                            ?>
                        </div>

                        <div class="entry-date">
                            <span class="published-date">ANNÉE : <?php echo get_the_date('Y'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="navigation-post-thumbnail">
                    <div class="container-contact-button">
                        <p>Cette photo vous intéresse ?</p>
                        <button class="contact-button single-photo" data-photo-ref="<?php echo esc_attr($reference); ?>">Contact</button>
                    </div>

                    <div class="container-navigation">
    <?php
    // Récupérer le post courant
    $current_post_id = get_the_ID();

    // Arguments pour trouver le post précédent
    $prev_post = get_posts([
        'posts_per_page' => 1,
        'post_type' => 'photo', 
        'orderby' => 'date',
        'order' => 'DESC',
        'date_query' => [
            'before' => get_the_date('Y-m-d H:i:s', $current_post_id),
        ],
    ]);

    // Arguments pour trouver le post suivant
    $next_post = get_posts([
        'posts_per_page' => 1,
        'post_type' => 'photo', 
        'orderby' => 'date',
        'order' => 'ASC',
        'date_query' => [
            'after' => get_the_date('Y-m-d H:i:s', $current_post_id),
        ],
    ]);
    ?>

    <?php if (!empty($prev_post)) : ?>
        <a href="<?php echo get_permalink($prev_post[0]->ID); ?>" class="prev-photo">
            &#8592;
            <div class="thumbnail-preview">
                <?php echo get_the_post_thumbnail($prev_post[0]->ID, 'thumbnail'); ?>
            </div>
        </a>
    <?php endif; ?>

    <?php if (!empty($next_post)) : ?>
        <a href="<?php echo get_permalink($next_post[0]->ID); ?>" class="next-photo">
            &#8594;
            <div class="thumbnail-preview">
                <?php echo get_the_post_thumbnail($next_post[0]->ID, 'thumbnail'); ?>
            </div>
        </a>
    <?php endif; ?>
</div>
    </div>

                <!-- Suggestions de photos de la même catégorie -->
                <div class="suggestion-post-thumbnail">
    <h3>VOUS AIMERIEZ AUSSI</h3>
    <div class="suggested-photo">
    <?php
    if ($categories && !is_wp_error($categories)) {
        $first_category = $categories[0]->term_id;

        $suggestion_args = array(
            'post_type' => 'photo',
            'posts_per_page' => 2,
            'post__not_in' => array(get_the_ID()),
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie', // Slug de la taxonomie CPT UI
                    'field' => 'term_id',
                    'terms' => $first_category,
                ),
            ),
        );

        $suggestion_query = new WP_Query($suggestion_args);

        if ($suggestion_query->have_posts()) :
            while ($suggestion_query->have_posts()) : $suggestion_query->the_post(); 
                $photo_reference = get_post_meta(get_the_ID(), 'reference_scf', true); // SCF pour la référence
                $photo_categories = get_the_terms(get_the_ID(), 'categorie'); // CPT UI pour les catégories
                ?>


                    <?php get_template_part('/templates_part/photo-block'); ?>
               
            <?php endwhile;
            wp_reset_postdata();
        else : 
            echo '<p>Aucune suggestion trouvée.</p>';
        endif;
    }
        ?>
        </div>
</div>
            </article>

        <?php endwhile;
    else : 
        echo '<p>Aucune photo trouvée.</p>';
    endif;
    ?>

</main>

<?php get_footer(); ?>