<?php
// Charger l'en-tête du thème
get_header(); 
?>

<main id="main-content" class="site-main">
    <?php
    // Démarrer la boucle pour afficher le contenu de la page
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>

            <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <?php
                // Afficher les champs personnalisés, s'il y en a
                if (current_user_can('edit_posts')) {
                    edit_post_link('Modifier cette page', '<p>', '</p>');
                }
                ?>
            </article>

        <?php endwhile;
    else : 
        echo '<p>Aucune page trouvée.</p>';
    endif;
    ?>
</main>

<?php
// Charger le pied de page du thème
get_footer(); 
?>