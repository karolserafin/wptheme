<section class="section section__about uk-section uk-padding-remove-vertical">
    <div class="uk-container uk-container-expand-right">
        <div class="uk-grid" uk-grid>
            <div class="uk-width-1-2@l uk-width-1-3@xl uk-position-relative">
                <div class="about__content">
                    <?php the_field( 'about__content' ); ?>
                </div>
            </div>

            <div class="about__image uk-width-1-2@l uk-width-2-3@xl">
                <img src="<?php the_field( 'about__image' ); ?>"/>
            </div>
        </div>
    </div>
</section>