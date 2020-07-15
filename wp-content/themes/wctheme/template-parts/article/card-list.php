<div class="uk-width-1-1 uk-width-1-2@s uk-width-1-2@m uk-width-1-3@l uk-width-1-3@xl">
    <article class="article article__card article__card--list">

        <div class="rounded-corrners">
        <div class="article-card-miniature">

            <img src="<?php echo get_field( 'image' ); ?>" alt="">

            <a class="archive-link" href="<?php echo get_month_link( get_the_time('Y'), get_the_time('m') ); ?>" title="<?php  _e( 'Przejdź do archiwum', 'wctheme' ) ?>">
                <time><?php the_date( 'j F Y' ); ?></time>
            </a>

            <h4><?php the_title(); ?></h4>

            <?php the_excerpt(); ?>

            <?php if ( get_field( 'is_product' ) ) : ?>
                <a class="button button--empty" href="<?php echo get_permalink( get_field( 'product' ) ); ?>" title="<?php the_title(); ?>"><?php _e( 'Zobacz produkt', 'wctheme' ) ?></a>
            <?php else: ?>
                <a class="button button--empty" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php  _e( 'Czytaj dalej', 'wctheme' ) ?></a>
            <?php endif; ?>
            
        </div>
        
    </article>
</div>

