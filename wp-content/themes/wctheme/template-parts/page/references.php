<section class="references">
    <div class="references__content">
        <h2 class="uk-heading-line uk-text-center section-title uk-margin-remove"><?php the_field( 'references__title' ); ?></h2>

        <?php if ( get_field( 'references' ) ) : ?>

            <div class="references__list" uk-slider>
                <div class="uk-position-relative">
                    <div class="uk-slider-container">
                        <ul class="uk-slider-items uk-child-width-1-1 uk-child-width-1-2@m uk-grid">
                            <?php while ( the_repeater_field( 'references' ) ) : ?>

                                <li class="references__li">
                                    <div class="references__item">
                                        <p class="references__item__content"><?php echo get_sub_field( 'reference__content' ); ?></p>
                                        <p class="references__item__author"><?php echo get_sub_field( 'reference__author' ); ?></p>
                                    </div>
                                </li>

                            <?php endwhile; ?>
                        </ul>
                    </div>

                    <div class="uk-visible@s uk-hidden@l">
                        <a class="uk-position-center-left uk-position-small" href="#" uk-slider-item="previous">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="20" viewBox="0 0 32 20">
                                <g transform="rotate(-180 16 10)">
                                    <path fill="#bf883b"
                                          d="M31.805 9.558l-10-9.375a.698.698 0 0 0-.943 0 .598.598 0 0 0 0 .884l8.862 8.308H.667C.298 9.375 0 9.655 0 10c0 .346.298.625.667.625h29.057l-8.862 8.308a.598.598 0 0 0 0 .884c.13.122.3.183.471.183.17 0 .341-.061.472-.183l10-9.375a.598.598 0 0 0 0-.884z"/>
                                </g>
                            </svg>
                        </a>
                        <a class="uk-position-center-right uk-position-small" href="#" uk-slider-item="next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="31" height="20" viewBox="0 0 31 20">
                                <path fill="#bf883b"
                                      d="M30.81 9.558L21.124.183a.66.66 0 0 0-.913 0 .61.61 0 0 0 0 .884l8.585 8.308H.645A.635.635 0 0 0 0 10c0 .346.289.625.646.625h28.15l-8.586 8.308a.61.61 0 0 0 0 .884.655.655 0 0 0 .457.183c.165 0 .33-.061.456-.183l9.688-9.375a.61.61 0 0 0 0-.884z"/>
                            </svg>
                        </a>
                    </div>

                    <div class="uk-visible@l uk-hidden@xl">
                        <a class="uk-position-center-left-out uk-position-small" href="#" uk-slider-item="previous">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="20" viewBox="0 0 32 20">
                                <g transform="rotate(-180 16 10)">
                                    <path fill="#bf883b"
                                          d="M31.805 9.558l-10-9.375a.698.698 0 0 0-.943 0 .598.598 0 0 0 0 .884l8.862 8.308H.667C.298 9.375 0 9.655 0 10c0 .346.298.625.667.625h29.057l-8.862 8.308a.598.598 0 0 0 0 .884c.13.122.3.183.471.183.17 0 .341-.061.472-.183l10-9.375a.598.598 0 0 0 0-.884z"/>
                                </g>
                            </svg>
                        </a>
                        <a class="uk-position-center-right-out uk-position-small" href="#" uk-slider-item="next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="31" height="20" viewBox="0 0 31 20">
                                <path fill="#bf883b"
                                      d="M30.81 9.558L21.124.183a.66.66 0 0 0-.913 0 .61.61 0 0 0 0 .884l8.585 8.308H.645A.635.635 0 0 0 0 10c0 .346.289.625.646.625h28.15l-8.586 8.308a.61.61 0 0 0 0 .884.655.655 0 0 0 .457.183c.165 0 .33-.061.456-.183l9.688-9.375a.61.61 0 0 0 0-.884z"/>
                            </svg>
                        </a>
                    </div>

                    <div class="uk-visible@xl">
                        <a class="uk-position-center-left-out uk-position-large" href="#" uk-slider-item="previous">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="20" viewBox="0 0 32 20">
                                <g transform="rotate(-180 16 10)">
                                    <path fill="#bf883b"
                                          d="M31.805 9.558l-10-9.375a.698.698 0 0 0-.943 0 .598.598 0 0 0 0 .884l8.862 8.308H.667C.298 9.375 0 9.655 0 10c0 .346.298.625.667.625h29.057l-8.862 8.308a.598.598 0 0 0 0 .884c.13.122.3.183.471.183.17 0 .341-.061.472-.183l10-9.375a.598.598 0 0 0 0-.884z"/>
                                </g>
                            </svg>
                        </a>
                        <a class="uk-position-center-right-out uk-position-large" href="#" uk-slider-item="next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="31" height="20" viewBox="0 0 31 20">
                                <path fill="#bf883b"
                                      d="M30.81 9.558L21.124.183a.66.66 0 0 0-.913 0 .61.61 0 0 0 0 .884l8.585 8.308H.645A.635.635 0 0 0 0 10c0 .346.289.625.646.625h28.15l-8.586 8.308a.61.61 0 0 0 0 .884.655.655 0 0 0 .457.183c.165 0 .33-.061.456-.183l9.688-9.375a.61.61 0 0 0 0-.884z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <ul class="uk-hidden@s uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
            </div>

        <?php endif; ?>
    </div>
</section>