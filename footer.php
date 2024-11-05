
</main>

<footer class="site_footer">
   
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'footer-menu',
			'container_class' => 'footer-menu-class'
		)
	);
	?>
	<p class="item-footer">TOUS DROITS RESERVES</p>

</footer>



<?php wp_footer(); ?>

</body>

</html>