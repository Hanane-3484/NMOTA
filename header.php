<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ma page</title>

	<?php wp_head(); ?>

</head>

<body>

<div id="Header">
    <div id="logo">
    <a href="http://nathalie-mota.local/"><img class="Logo" src="<?php echo get_template_directory_uri(); ?>/Assets/Medias/Logo.png" alt="Logo du site"></a>
    </div>
   <!-- Bouton Burger -->
   <div id="burger-icon" onclick="toggleMenu()">☰</div>
    <nav id="menu-header" class="menu-header">
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'header-menu',
                'container_class' => 'header-menu-class',
            )
        );
        ?>
    </nav>
</div>
	<main>