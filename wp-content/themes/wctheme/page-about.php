<?php
/**
 *    Template Name: O nas
 *
 * @package wctheme
 * @since wctheme 1.0
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

    <?php get_template_part( '/template-parts/page/header' ); ?>

    <section class="about">
        <?php get_template_part( '/template-parts/page/about' ); ?>

        <div class="uk-container">
            <?php get_template_part( '/template-parts/page/team' ); ?>
            <?php get_template_part( '/template-parts/page/references' ); ?>
        </div>

        <?php get_template_part( '/template-parts/home/instagram' ); ?>
    </section>

<?php endwhile; ?>

<?php get_footer();