<?php
// Charger l'en-tête du thème
get_header(); 
?>

<main id="main-content" class="site-main">
    <?php
    // Démarrer la boucle pour afficher le contenu de l'article
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-meta">
                        <span class="posted-on"><?php the_date(); ?></span> |
                        <span class="author"><?php the_author(); ?></span>
                    </div>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <footer class="entry-footer">
                    <div class="categories"><?php the_category(', '); ?></div>
                    <div class="tags"><?php the_tags('Tags: ', ', '); ?></div>
                </footer>
            </article>

            <?php
            // Afficher les commentaires et le formulaire de commentaire, s'ils sont activés
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        <?php endwhile;
    else : 
        echo '<p>Aucun contenu trouvé.</p>';
    endif;
    ?>
</main>

<?php
// Charger le pied de page du thème
get_footer(); 
?>