<?php
/**
 *    Template Name: Strony tekstowe
 *
 * @package wctheme
 * @since wctheme 1.0
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

    <?php get_template_part( '/template-parts/page/header' ); ?>

    <section class="page-content">
        <div class="uk-container">
            <?php get_template_part( '/template-parts/page/text' ); ?>
        </div>
    </section>

<?php endwhile; ?>

<?php get_footer();