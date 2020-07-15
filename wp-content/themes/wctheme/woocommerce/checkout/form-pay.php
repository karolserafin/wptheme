<?php
/**
 * Pay for order form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-pay.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

$totals = $order->get_order_item_totals(); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
?>
<div class="uk-container uk-container-large">
    <section class="uk-section uk-section-small uk-padding-large uk-padding-remove-horizontal">
        <form id="order_review" method="post">
            <h2><?php esc_html_e( 'Płatność nieudana', 'wctheme' ); ?></h2>
            <h3><?php esc_html_e( 'Twoja płatność nie została potwierdzona.', 'wctheme' ); ?></h3>
            <p><?php esc_html_e( 'Spróbuj raz jeszcze aby dokończy proces składania zamówienia.', 'desep' ) ?></p>

            <input type="hidden" name="woocommerce_pay" value="1"/>

            <?php wc_get_template( 'checkout/terms.php' ); ?>

            <?php do_action( 'woocommerce_pay_order_before_submit' ); ?>

            <?php echo apply_filters( 'woocommerce_pay_order_button_html', '<button type="submit" class="button checkout-button alt" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>

            <?php do_action( 'woocommerce_pay_order_after_submit' ); ?>

            <?php wp_nonce_field( 'woocommerce-pay', 'woocommerce-pay-nonce' ); ?>
        </form>
    </section>
</div>
