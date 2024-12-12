
</main>

<?php
// la modale de contact et la lightbox
get_template_part('templates_part/modal');
?>

<?php get_template_part('/templates_part/lightbox'); ?>

<!--le fichier JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>


<footer class="site_footer">
   
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'footer-menu',
			'container_class' => 'footer-menu-class'
		)
	);
	?>
	<span class="item-footer">TOUS DROITS RESERVES</span>

</footer>



<?php wp_footer(); ?>

</body>

</html>