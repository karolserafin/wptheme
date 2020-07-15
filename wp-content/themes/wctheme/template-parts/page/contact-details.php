<div class="contact-info">
	<h2 class="contact-info__header"><?php the_field( 'company__title' ); ?></h2>
	<p><?php the_field( 'company__address' ); ?></p>
	<div class="grupe-para">
		<p>NIP: <?php the_field( 'company__nip' ); ?></p>
		<p>KRS: <?php the_field( 'company__krs' ); ?></p>
	</div>
	
	
	<div class="grupe-para">
		<p>Tel:	<a href="tel:<?php the_field( 'company__phone' ); ?>"><?php the_field( 'company__phone' ); ?></a></p>
		<p>E-mail: <a href="mailto:<?php the_field( 'company__email' ); ?>"><?php the_field( 'company__email' ); ?></a></p>
	</div>
	
	

	<?php if ( has_nav_menu( 'social' ) ) : ?>
		<nav role="navigation" class="footer__menu footer__menu--social">
			
			<?php wp_nav_menu(
				array(
					'container'  			=> '',
					'menu_id' 				=> 'social',
					'theme_location' 		=> 'social',
				)
			); ?>
		
		</nav>
	<?php endif; ?>
</div>