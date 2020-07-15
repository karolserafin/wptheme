<section id="zespol" class="uk-section uk-section-large uk-padding-remove-bottom">

    <div class="members">

        <h2 class="uk-heading-line uk-text-center section-title uk-margin-remove"><?php the_field( 'team__title' ); ?></h2>

        <?php if ( get_field( 'team__list' ) ) : ?>

            <div class="members__list">

                <?php $i = 0; ?>
                <?php while ( the_repeater_field( 'team__list' ) ) : ?>

                    <?php if ( $i % 2 == 0 ): ?>
                        <div class="members__item uk-grid uk-child-width-1-2@s" uk-grid>
                            <div class="members__item__image">
                                <img src="<?php echo get_sub_field( 'member__photo' ); ?>"
                                     alt="<?php echo get_sub_field( 'member__name' ); ?>"/>
                            </div>

                            <div class="members__item__content">
                                <div>
                                    <h3 class="members__item__name"><?php echo get_sub_field( 'member__name' ); ?></h3>
                                    <p class="members__item__title"><?php echo get_sub_field( 'member__title' ); ?></p>
                                </div>

                                <p class="members__item__bio"><?php echo get_sub_field( 'member__bio' ); ?></p>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="members__item uk-grid uk-child-width-1-2@s" uk-grid>
                            <div class="members__item__content">
                                <div>
                                    <h3 class="members__item__name"><?php echo get_sub_field( 'member__name' ); ?></h3>
                                    <p class="members__item__title"><?php echo get_sub_field( 'member__title' ); ?></p>
                                </div>

                                <p class="members__item__bio"><?php echo get_sub_field( 'member__bio' ); ?></p>
                            </div>

                            <div class="members__item__image">
                                <img src="<?php echo get_sub_field( 'member__photo' ); ?>"
                                     alt="<?php echo get_sub_field( 'member__name' ); ?>"/>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php $i++; ?>
                <?php endwhile; ?>

            </div>

        <?php endif; ?>

    </div>

</section>