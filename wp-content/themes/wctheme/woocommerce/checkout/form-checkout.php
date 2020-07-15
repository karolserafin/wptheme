<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

$active_step = is_user_logged_in() || isset( $_COOKIE['checkout_step'] ) && ( $_COOKIE['checkout_step'] === '3' || $_COOKIE['checkout_step'] === '3-register' ) ? 'shipping' : 'login';
?>

<section class="uk-section uk-padding-remove-top">
    <div class="uk-container">
        <div class="steps uk-flex">
            <span class="steps__divider"></span>

            <div class="steps__step steps__step--done" data-step="cart">
                <span class="steps__step__icon">
                    <img src="<?= get_template_directory_uri() . '/assets/img/svg/steps/done.svg' ?>" alt="cart"/>
                </span>
                <p class="steps__step__title"><?php _e( 'Koszyk', 'wctheme' ); ?></p>
            </div>
            <span class="steps__divider"></span>

            <div class="steps__step <?php if ( $active_step == 'login' ): ?>steps__step--active<?php else: ?>steps__step--done<?php endif; ?>"
                 data-step="login">
                <span class="steps__step__icon">
                    <?php if ( $active_step == 'login' ): ?>
                        <img src="<?= get_template_directory_uri() . '/assets/img/svg/steps/login.svg' ?>" alt="login"/>
                    <?php else: ?>
                        <img src="<?= get_template_directory_uri() . '/assets/img/svg/steps/done.svg' ?>" alt="cart"/>
                    <?php endif; ?>
                </span>
                <p class="steps__step__title"><?php _e( 'Logowanie', 'wctheme' ); ?></p>
            </div>
            <span class="steps__divider"></span>

            <div class="steps__step <?php if ( $active_step == 'shipping' ): ?>steps__step--active<?php endif; ?>"
                 data-step="shipping">
                <span class="steps__step__icon">
                    <img src="<?= get_template_directory_uri() . '/assets/img/svg/steps/shipping.svg' ?>"
                         alt="shipping"/>
                </span>
                <p class="steps__step__title"><?php _e( 'Dostawa', 'wctheme' ); ?></p>
            </div>
            <span class="steps__divider"></span>

            <div class="steps__step" data-step="payment">
                <span class="steps__step__icon">
                    <img src="<?= get_template_directory_uri() . '/assets/img/svg/steps/payment.svg' ?>" alt="payment"/>
                </span>
                <p class="steps__step__title"><?php _e( 'Płatność', 'wctheme' ); ?></p>
            </div>
            <span class="steps__divider"></span>

            <div class="steps__step" data-step="confirmation">
                <span class="steps__step__icon">
                    <img src="<?= get_template_directory_uri() . '/assets/img/svg/steps/confirmation.svg' ?>"
                         alt="confirmation"/>
                </span>
                <p class="steps__step__title"><?php _e( 'Potwierdzenie', 'wctheme' ); ?></p>
            </div>
            <span class="steps__divider"></span>
        </div>
    </div>

    <div class="uk-container uk-container-small">
        <section
                class="uk-section uk-section-small step__content step__content--login<?php if ( $active_step == 'login' ): ?> step__content--active<?php endif; ?>">

            <div class="uk-grid-large uk-grid-column-large uk-grid-divider uk-child-width-1-2@s" uk-grid>
                <div>
                    <h2><?php echo __('Jeśli masz już konto w sklepie wctheme, Zaloguj się', 'wctheme'); ?></h2>
                    <?php do_action( 'facebook_login_button' ); ?>
                    <p class="divider uk-heading-line uk-text-center uk-text-uppercase">
                        <span><?php _e( 'lub', 'wctheme' ) ?></span>
                    </p>

                    <form class="form woocomerce-form woocommerce-form-login" method="post">
                        <?php do_action( 'woocommerce_login_form_start' ); ?>

                        <div class="uk-grid uk-grid-small" uk-grid>
                            <div class="uk-width-1-1">
                                <input class="form__input" type="text" name="username" id="username"
                                       value="<?php echo (!empty( $_POST['username'] )) ? esc_attr( $_POST['username'] ) : ''; ?>"
                                       placeholder="<?php esc_attr_e( 'e-mail:', 'wctheme' ); ?>"/>
                            </div>
                            <div class="uk-inline uk-width-1-1">
                                <button type="button" class="form__icon form__icon--flip" data-event="showPassword"
                                        data-input="password">
                                    <img src="<?= get_template_directory_uri() . '/assets/img/svg/woocommerce/view-password.svg' ?>"
                                         alt="view password"/>
                                </button>
                                <input class="form__input" type="password" name="password" id="password"
                                       placeholder="<?php esc_attr_e( 'hasło:', 'wctheme' ); ?>"/>
                            </div>
                            <div class="uk-width-1-1">
                                <div class="mm-login-rememberme-row">
                                    <label class="form__checkbox" for="remember-me-checkbox">
                                        <input class="form__checkbox__input" name="rememberme" id="remember-me-checkbox"
                                               type="checkbox">
                                        <span><?php _e( 'Remember me', 'woocommerce' ); ?></span>
                                    </label>
                                </div>
                            </div>

                            <?php do_action( 'woocommerce_login_form' ); ?>

                            <div class="uk-width-1-1">
                                <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                                <input type="submit" class="button login-button uk-width-1-1 uk-margin-small-top"
                                       name="login"
                                       value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>"/>
                            </div>

                            <div class="uk-width-1-1 uk-margin-small-top">
                                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"
                                   class="button lost-password-button">
                                    <?php _e( 'Lost your password?', 'woocommerce' ); ?>
                                </a>
                            </div>

                        </div>

                        <?php do_action( 'woocommerce_login_form_end' ); ?>
                    </form>
                </div>

                <div>
                    <div class="register__info">
                        <h2><?php _e( 'Nie masz jeszcze konta?', 'wctheme' ); ?></h2>
                        <p><strong><?php _e( 'Otrzymasz same korzyści:', 'wctheme' ); ?></strong></p>
                        <ul>
                            <li><?php _e( 'Podgląd statusu realizacji zamówień', 'wctheme' ); ?></li>
                            <li><?php _e( 'Podgląd historii zakupów', 'wctheme' ); ?></li>
                            <li><?php _e( 'Brak konieczności wprowadzania danych przy następnych zakupach', 'wctheme' ); ?></li>
                        </ul>

                        <?php do_action( 'facebook_login_button' ); ?>
                        <button type="button" id="register-button"
                                class="button register-button uk-width-1-1 uk-margin-small-top">
                            <?php _e( 'Zarejestruj się przez e-mail', 'wctheme' ); ?>
                        </button>
                        <p class="divider uk-heading-line uk-text-center uk-text-uppercase">
                            <span><?php _e( 'lub', 'wctheme' ) ?></span>
                        </p>
                        <a id="guest-button"
                           class="button buy-as-guest login-button"><?php _e( 'Złóż zamówienie jako gość', 'wctheme' ); ?></a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="uk-container uk-container-large">
        <section class="uk-section uk-section-small">

            <div id="coupon-form-to-submit" style="display: none;">
                <?php do_action( 'wctheme_woocomerce_shipping_coupon' ); ?>
            </div>

            <form name="checkout" method="post" class="checkout woocommerce-checkout"
                  action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
                <input type="hidden" id="checkout-validator" name="validate" value="false" />
                <div class="step__content step__content--shipping<?php if ( $active_step == 'shipping' ): ?> step__content--active<?php endif; ?>">
                    <div class="uk-grid-column-large uk-grid-row-small uk-child-width-1-2@s" uk-grid>
                        <div class="shipping">

                            <div class="shipping__flat-rate">
                                <div class="shipping__postal-code">
                                    <h2 class="uk-margin-remove-bottom"><?php _e( 'Wpisz swój kod pocztowy', 'wctheme' ); ?></h2>
                                    <h3 class="uk-margin-small-bottom uk-margin-small-top"><?php _e( 'Będziemy mogli określić sposób dostawy lub odbioru zamówienia', 'wctheme' ); ?></h3>

                                    <div class="shipping__postal-code uk-width-1-1 uk-margin-bottom">
                                        <input class="form__input" type="text" maxlength="6" name="postal_code" id="postal_code"
                                               placeholder="<?php esc_attr_e( 'Kod pocztowy*', 'wctheme' ); ?>"/>
                                    </div>
                                </div>
                            </div>

                            <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
                                <div class="shipping__options uk-hidden uk-margin-medium-bottom">
                                    <h2><?php _e( 'Sposób dostawy', 'wctheme' ); ?></h2>
                                    <?php // wc_cart_totals_shipping_html(); ?>
                                </div>
                            <?php endif; ?>

                            <div class="shipping__local-pickup uk-hidden shipping__local-pickup--is-open">
                                <div class="shipping__locations">
                                    <h3><?php _e( 'Wybierz miejsce odbioru', 'wctheme' ); ?></h3>

                                    <?php $locations = wctheme_get_locations_list(); ?>
                                    <?php if ( $locations ) : ?>
                                        <ul id="shipping_location">
                                            <?php foreach ( $locations as $location ) : ?>
                                                <li>
                                                    <label class="form__radio" for="location-<?= $location['id']; ?>">
                                                        <input type="radio" name="location"
                                                               id="location-<?= $location['id']; ?>"
                                                               value="<?= $location['id']; ?>"
                                                               <?php if (get_field( 'new__location', $location['id'] )) : ?>data-new="true"<?php endif; ?>>
                                                        <span><?= $location['name']; ?></span>
                                                    </label>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <?php _e( 'Brak dostępnych miejsc odbioru', 'wctheme' ); ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="shipping__calendar uk-hidden uk-margin-bottom">

                                <?php
                                /**
                                 *    Metoda do sprawdzania czy w koszyku jest tort większy niż 1KG - jeżeli tak - trzeba ustawić najbliższy mozliwy termin odbioru na +3 dni
                                 *
                                 * @return true - jeżeli jest tort powyżej 1kg w koszyku
                                 * @return false - w przeciwnym wypadku
                                 *
                                 */
                                $deleyed_shipping = wctheme_get_first_available_shipping_day();
                                $availability = wctheme_check_product_availability_dates();
                                ?>
                                <div id="calendar" class="calendar" data-delayed="<?= $deleyed_shipping ?>">
                                    <h3><?php _e( 'Wybierz datę i godzinę dostawy / odbioru', 'wctheme' ); ?></h3>
                                    <input class="uk-hidden" type="hidden" name="shipping_date">
                                </div>
                            </div>

                            <div class="shipping__time uk-hidden">
                                <?php if ( $locations ) : ?>
                                    <h3><?php _e( 'Godzina dostawy / odbioru', 'wctheme' ); ?></h3>

                                    <div class="form__select-wrapper">
                                        <select name="shipping_time" id="shipping_time"
                                                class="form__select uk-width-1-1"></select>
                                    </div>
                                <?php else: ?>
                                    <?php _e( 'Brak dostępnych godzin odbioru', 'wctheme' ); ?>
                                <?php endif; ?>
                            </div>

                            <?php if ( $checkout->get_checkout_fields() ) : ?>

                                <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                                <div class="shipping__billing">
                                    <?php do_action( 'woocommerce_checkout_billing' ); ?>
                                </div>

                                <?php if ( !is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
                                    <div class="shipping__account woocommerce-account-fields uk-margin-medium-bottom">
                                        <h3 class="uk-margin-small-top uk-margin-small-bottom"><?php _e( 'Hasło do konta', 'wctheme' ); ?>
                                            <span class="account-password-info-icon" uk-tooltip="title: <?php _e( 'Hasło zostanie przypisane do adresu e-mail podanego w zamówieniu. Do swojego konta zalogujesz się za pomocą adresu e-mail podanego wyżej w zamówieniu.; pos: top-right', 'wctheme' ); ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve"><path d="M50,5C25.187,5,5,25.187,5,50c0,24.813,20.187,45,45,45c24.813,0,45-20.188,45-45C95,25.187,74.813,5,50,5z M50,90.08  C27.9,90.08,9.92,72.1,9.92,50C9.92,27.899,27.9,9.919,50,9.919c22.1,0,40.08,17.98,40.08,40.081C90.08,72.1,72.1,90.08,50,90.08z"/><path d="M50,26.662c-2.297,0-4.164,1.868-4.164,4.164c0,2.297,1.867,4.166,4.164,4.166s4.164-1.869,4.164-4.166  C54.164,28.53,52.297,26.662,50,26.662z"/><path d="M50,40.078c-1.516,0-2.747,1.232-2.747,2.747v27.89c0,1.516,1.231,2.748,2.747,2.748c1.516,0,2.747-1.232,2.747-2.748  v-27.89C52.747,41.311,51.516,40.078,50,40.078z"/></svg>
                                            </span>
                                        </h3>
                                        <?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

                                        <?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

                                            <div>
                                                <div id="create-account" class="uk-hidden">
                                                    <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
                                                           id="createaccount" <?php checked( (true === $checkout->get_value( 'createaccount' ) || (true === apply_filters( 'woocommerce_create_account_default_checked', false ))), true ); ?>
                                                           type="checkbox" name="createaccount" value="1"/>
                                                </div>
                                                <?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
                                                    <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
                                                <?php endforeach; ?>
                                                <div class="clear"></div>
                                                <p><?php echo __( 'Użyj 8 lub więcej znaków, w tym liter, cyfr oraz symboli.', 'wctheme' ); ?></p>
                                            </div>

                                        <?php endif; ?>

                                        <?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="shipping__present">
                                    <?php do_action( 'woocommerce_after_checkout_shipping' ); ?>
                                </div>

                                <div class="shipping__payment">
                                    <h2><?php _e( 'Metoda płatności', 'wctheme' ) ?></h2>
                                    <?php
                                    $enabled_gateways = wctheme_get_enabled_gateways_list();

                                    if ( $enabled_gateways ): ?>
                                        <ul class="uk-flex uk-flex-wrap">
                                            <?php foreach ( $enabled_gateways as $gateway ) {
                                                wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
                                            } ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>

                                <div class="shipping__shipping uk-margin-top">
                                    <?php
                                    /**
                                     *    checkout_shipping
                                     *
                                     *    dostępne tylko dla metody wysyłki innen niż osbiór osobisty - do oskryptowania w JS
                                     */
                                    ?>
                                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                                </div>

                                <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

                            <?php endif; ?>

                            <div class="shipping__coupon uk-margin-top">
                                <h3><?php _e( 'Czy posiadasz kupon rabatowy?', 'wctheme' ) ?></h3>
                                <div class="uk-position-relative coupon">
                                    <input id="coupon" type="text" name="coupon" class="form__input uk-width-1-1"
                                           placeholder="<?php _e( 'Kod kuponu', 'wctheme' ); ?>">

                                    <button type="button" class="button register-button" name="add_coupon"
                                            value="<?php _e( 'Zatwierdź', 'wctheme' ); ?>">
                                        <?php _e( 'Zatwierdź', 'wctheme' ); ?>
                                    </button>
                                </div>
                            </div>

                            <div class="shipping__rules">
                                <h2><?php _e( 'Akceptacja regulaminu', 'wctheme' ); ?></h2>
                                <p class="form-row validate-required">
                                    <label class="form__checkbox woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                                        <input type="checkbox"
                                               class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
                                               name="terms" id="terms">
                                        <span class="woocommerce-terms-and-conditions-checkbox-text">
                                            <?php printf( __( 'Akceptuję warunki <a href="%s">regulaminu</a> i <a href="%s">polityki prywatności</a>', 'wctheme' ), get_permalink( wc_get_page_id( 'terms' ) ), get_privacy_policy_url() ) ?>
                                        </span>
                                    </label>
                                </p>
                            </div>
                        </div>

                        <div class="order__review">
                            <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                        </div>

                        <div class="order__place-order">
                            <?php do_action( 'wctheme_woocommerce_pay_button' ); ?>
                            <br><br>
                            <p><?php _e( 'Pola wymagane*', 'wctheme' ); ?></p>
                        </div>
                    </div>
                </div>
            </form>

            <?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
        </section>
    </div>
</section>

<aside class="checkout__postcode__info" style="display: none;">
    <div class="animation animation--seventh">  
        <svg class="animation__blender" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48.62 122.42"><defs><style>.cls-1{fill:#58595b;}</style></defs><g id="Warstwa_2" data-name="Warstwa 2"><g id="Layer_1" data-name="Layer 1"><path class="cls-1" d="M24.61,0a3,3,0,0,0-3.06,2.92l-.11,41.47C17.82,49.16.08,73.61,0,94.2c0,10.89,2.27,18.37,7.06,22.88,5,4.73,11.8,5.34,17.15,5.34,5.86,0,10.22-.9,13.72-2.82a18.14,18.14,0,0,0,7.92-9c1.84-4.23,2.74-9.6,2.77-16.41.07-20.59-17.49-45-21.07-49.81l.1-41.48A3,3,0,0,0,24.61,0ZM26,116.24a3.2,3.2,0,0,1-1.6.34c-1.19,0-2.26-.2-3.33-2.73-1.48-3.51-2.21-10.12-2.18-19.65,0-13,3.25-28.12,5.72-37.87,2.4,9.75,5.5,24.9,5.46,37.88C30,101.57,29.44,114.22,26,116.24ZM7.13,94.2c0-10.27,5-22,9.88-31.2-2,9.31-3.93,20.79-4,31.2,0,9.78.68,16.46,2.23,20.86a10.63,10.63,0,0,1-3.15-2.14C8.73,109.56,7.1,103.44,7.13,94.2Zm34.61,0c-.05,16.17-5.46,19.3-7.24,20.33-.32.19-.67.36-1,.53,1.6-4.45,2.32-11.16,2.35-20.86C35.87,83.79,34,72.3,32.08,63,36.94,72.18,41.78,83.92,41.74,94.21Z"/></g></g></svg>

        <svg class="animation__bowl" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 115 95.89"><defs><style>.cls-1{fill:#58595b;}</style></defs><g id="Warstwa_2" data-name="Warstwa 2"><g id="Layer_1" data-name="Layer 1"><path class="cls-1" d="M76,0V7h33V38.47a54.32,54.32,0,0,1-3.8,20.68,45.41,45.41,0,0,1-26.65,26,56.54,56.54,0,0,1-20.22,3.54,61.24,61.24,0,0,1-20.8-3.37,46.93,46.93,0,0,1-16.17-9.64A43.31,43.31,0,0,1,10.79,60.3,53.05,53.05,0,0,1,7,39.79V7H40V0H0V39.87A59.55,59.55,0,0,0,4.35,63.1,51.75,51.75,0,0,0,16.43,80.82,52.36,52.36,0,0,0,34.74,92a66.84,66.84,0,0,0,23.09,3.87,60.92,60.92,0,0,0,22.59-4.12A54.38,54.38,0,0,0,98.57,80.16,52.72,52.72,0,0,0,110.64,62,61.21,61.21,0,0,0,115,38.55V0Z"/></g></g></svg>
    </div>  
    <p><?php echo __( 'Trwa weryfikacja kodu pocztowego.', 'wctheme' ); ?></p>
</aside>
