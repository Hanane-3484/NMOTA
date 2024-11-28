<div class="photo-item">
                <a href="<?php the_permalink(); ?>"> <!-- Lien vers single-photo.php -->
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('medium'); // Affiche l'image à la une
                    } 
                    else {
                        echo '<img src="' . get_template_directory_uri() . '/Assets/Medias/default-photo.jpg" alt="Image par défaut">';
                    }
                    ?>
                </a>
</div>




           
  
            <!-- Icône Eye -->
            <img class="eye" src="<?php echo get_template_directory_uri(); ?>/Assets/Medias/eye.png" alt="Voir">
            <!-- Icône Fullscreen -->
            <img class="fullscreen" src="<?php echo get_template_directory_uri(); ?>/Assets/Medias/fullscreen.png" alt="Agrandir">
      
 
