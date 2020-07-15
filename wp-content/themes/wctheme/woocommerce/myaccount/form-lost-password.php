<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.2
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>
    <div class="uk-container uk-container-small">
        <section
                class="uk-section uk-section-small step__content step__content--login step__content--active">

            <div class="uk-grid-large uk-grid-column-large uk-grid-divider uk-child-width-1-2@s" uk-grid>
                <div>
                    <h2><?php _e( 'Nie pamiętasz hasła?', 'wctheme' ); ?></h2>

                    <p><?php _e( 'Nie martw się. Wyślemy Ci wiadomość, dzięki której ponownie ustawisz hasło.', 'wctheme' ); ?></p>

                    <form method="post" class="woocommerce-ResetPassword lost_reset_password">
                        <p class="uk-width-1-1">
                            <input class="uk-width-1-1 form__input woocommerce-Input woocommerce-Input--text input-text" type="text"
                                   name="user_login" id="user_login" autocomplete="username"
                                    placeholder="<?php esc_html_e( 'Username or email', 'woocommerce' ); ?>"/>
                        </p>

                        <div class="clear"></div>

                        <?php do_action( 'woocommerce_lostpassword_form' ); ?>

                        <p class="uk-width-1-1">
                            <input type="hidden" name="wc_reset_password" value="true"/>
                            <button type="submit" class="woocommerce-Button button login-button uk-width-1-1"
                                    value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
                        </p>

                        <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

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
                            <!-- <button type="button" class="button social-button uk-width-1-1">
                                <img src="<?= get_template_directory_uri() . '/assets/img/svg/facebook-icon.svg' ?>"
                                     alt="facebook"/>
                                <?php _e( 'Zarejestruj się przez facebooka', 'wctheme' ); ?>
                            </button> -->
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
<?php
do_action( 'woocommerce_after_lost_password_form' );
