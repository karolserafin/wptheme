<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>


<?php endif; ?>

<div class="uk-container uk-container-small">
    <section
            class="uk-section uk-section-small step__content step__content--login step__content--active" id="form__login">

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
                                    <input class="form__checkbox__input" name="rememberme"
                                           id="remember-me-checkbox"
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

                    <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
                        <?php do_action( 'facebook_login_button' ); ?>
                        <button type="button" id="register-button"
                                class="button register-button uk-width-1-1 uk-margin-small-top">
                            <?php _e( 'Zarejestruj się przez e-mail', 'wctheme' ); ?>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="uk-container uk-container-large">
    <section
            class="uk-section uk-section-small step__content step__content--register">

        <div class="uk-grid-large uk-grid-column-large uk-flex-middle uk-flex-right uk-child-width-1-2@s" uk-grid>
            <div class="uk-width-1-2@s uk-width-1-3@m">
                <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
                    <h2><a href="#" id="go-back"></a> <?php _e( 'Załóż konto', 'wctheme' ); ?></h2>
                    <p class="subheading"><?php _e( 'Umożliwimy Ci składanie zamówień tak szybko, jak to tylko możliwe.', 'wctheme' ); ?></p>

                    <form class="form" method="post">
                        <div class="uk-grid uk-grid-small" uk-grid>
                            <?php do_action( 'woocommerce_register_form_start' ); ?>

                            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                                <div class="uk-width-1-1 uk-hidden">
                                    <input type="hidden" class="form__input" name="username" id="reg_username"
                                           value="<?php echo (!empty( $_POST['username'] )) ? esc_attr( $_POST['username'] ) : ''; ?>"
                                           placeholder="<?php esc_attr_e( 'nazwa użytkownika:', 'wctheme' ); ?>"/>
                                </div>
                            <?php endif; ?>

                            <div class="uk-width-1-1">
                                <input class="form__input" type="email" name="email" id="reg_email"
                                       value="<?php echo (!empty( $_POST['email'] )) ? esc_attr( $_POST['email'] ) : ''; ?>"
                                       placeholder="<?php esc_attr_e( 'e-mail:', 'wctheme' ); ?>"/>
                            </div>

                            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                                <div class="uk-inline uk-width-1-1 uk-margin-small-top">
                                    <button type="button" class="form__icon form__icon--flip" data-event="showPassword"
                                            data-input="reg_password">
                                        <img src="<?= get_template_directory_uri() . '/assets/img/svg/woocommerce/view-password.svg' ?>"
                                             alt="view password"/>
                                    </button>
                                    <input class="form__input" type="password" name="password" id="reg_password"
                                           placeholder="<?php esc_attr_e( 'hasło:', 'wctheme' ); ?>"/>
                                </div>
                            <?php endif; ?>

                            <hr class="uk-margin-small-top">
                            <p class="additional-text"><?php _e( 'Użyj 8 lub więcej znaków, w tym liter, cyfr oraz symboli.', 'wctheme' ); ?></p>

                            <!-- Spam Trap -->
                            <div style="<?php echo((is_rtl()) ? 'right' : 'left'); ?>: -999em; position: absolute;">
                                <label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input
                                        type="text" name="email_2" id="trap" tabindex="-1"
                                        autocomplete="off"/></div>

                            <div class="uk-width-1-1">
                                <?php do_action( 'woocommerce_register_form' ); ?>
                            </div>

                            <div class="uk-width-1-1">
                                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                                <input type="submit" class="button login-button uk-width-1-1"
                                       name="register"
                                       value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"/>
                            </div>

                            <?php do_action( 'woocommerce_register_form_end' ); ?>
                        </div>
                    </form>
                <?php endif; ?>
            </div>

            <div class="form__register__image">
                <img src="<?= get_template_directory_uri(); ?>/assets/img/local.png" alt="Lokal">
            </div>
        </div>
    </section>
</div>


<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
