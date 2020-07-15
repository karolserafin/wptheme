<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

if ( isset($_REQUEST['error']) && $_REQUEST['error'] == 501 ) {
    $order->update_status( 'payment-error', __( 'Błąd płatności', 'wctheme' ) );
}

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

            <div class="steps__step steps__step--done"
                 data-step="login">
                <span class="steps__step__icon">
                        <img src="<?= get_template_directory_uri() . '/assets/img/svg/steps/done.svg' ?>" alt="cart"/>
                </span>
                <p class="steps__step__title"><?php _e( 'Logowanie', 'wctheme' ); ?></p>
            </div>
            <span class="steps__divider"></span>

            <div class="steps__step steps__step--done"
                 data-step="shipping">
                <span class="steps__step__icon">
                    <img src="<?= get_template_directory_uri() . '/assets/img/svg/steps/done.svg' ?>"
                         alt="shipping"/>
                </span>
                <p class="steps__step__title"><?php _e( 'Dostawa', 'wctheme' ); ?></p>
            </div>
            <span class="steps__divider"></span>

            <?php if ( $order->has_status( 'payment-error' ) ) : ?>
                <div class="steps__step steps__step--error" data-step="payment">
                    <span class="steps__step__icon">
                        <img src="<?= get_template_directory_uri() . '/assets/img/svg/steps/error.svg' ?>"
                             alt="payment"/>
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
            <?php else: ?>
                <div class="steps__step steps__step--done" data-step="payment">
                    <span class="steps__step__icon">
                        <img src="<?= get_template_directory_uri() . '/assets/img/svg/steps/done.svg' ?>"
                             alt="payment"/>
                    </span>
                    <p class="steps__step__title"><?php _e( 'Płatność', 'wctheme' ); ?></p>
                </div>
                <span class="steps__divider"></span>

                <div class="steps__step steps__step--active" data-step="confirmation">
                    <span class="steps__step__icon">
                        <img src="<?= get_template_directory_uri() . '/assets/img/svg/steps/confirmation.svg' ?>"
                             alt="confirmation"/>
                    </span>
                    <p class="steps__step__title"><?php _e( 'Potwierdzenie', 'wctheme' ); ?></p>
                </div>
                <span class="steps__divider"></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="uk-container uk-container-large uk-margin-large-top">
        <div class="woocommerce-order">

            <?php
            if ( $order ) :

                do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

                <?php if ( $order->has_status( 'payment-error' ) ) : ?>
                    <h2 class="uk-text-center"><?php esc_html_e( 'Płatność nieudana', 'wctheme' ); ?></h2>

                    <p class="uk-text-center">
                        <?php _e( 'Twoja płatność nie została potwierdzona. Spróbuj raz jeszcze aby dokończy proces składania zamówienia.' ); ?><br><br>
                        <a class="uk-text-center button checkout-button" href="<?php echo home_url(); ?>"><?php _e( 'Przejdź do strony głównej', 'wctheme' ); ?></a>
                    </p>

                <?php else : ?>

                    <h2 class="uk-text-center">
                        <?php printf('Dziękujemy. Otrzymaliśmy Twoje zamówienie nr %s.', (string) $order->get_id() ); ?>
                        <br>
                        <?php echo esc_html__('Potwierdzenie Twojego zamówienia wraz z wszystkimi szczegółami wysłaliśmy na adres mailowy.', 'wctheme'); ?>        
                    </h2>

                    <a class="uk-text-center button checkout-button" href="<?php echo home_url(); ?>"><?php esc_html_e( 'Przejdź do strony głównej', 'wctheme' ); ?></a>
                <?php endif; ?>

            <?php else : ?>

                <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

            <?php endif; ?>

        </div>
    </div>
</section>