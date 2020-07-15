<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="cart_totals">
    <?php do_action( 'woocommerce_before_cart_totals' ); ?>
    <div class="cart__summary uk-flex uk-flex-right">
        <div class="cart-subtotal">
            <p>
                <strong><?php esc_html_e( 'Koszt zamówienia:', 'wctheme' ); ?></strong>
                <span><?php wc_cart_totals_subtotal_html(); ?></span>
            </p>
            <span><?php esc_html_e( '+ koszty ewentualnej dostawy', 'wctheme' ); ?></span>
        </div>

        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
            <tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                <th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
                <td data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
            </tr>
        <?php endforeach; ?>
    </div>

    <div class="cart__actions uk-flex uk-flex-center uk-flex-between@s uk-flex-middle uk-flex-wrap">
        <a href="<?= esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"
           class="button continue-button continue-button__regular"><?php _e( 'Kontynuuj zakupy', 'wctheme' ); ?></a>

        <?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
    </div>

    <?php do_action( 'woocommerce_after_cart_totals' ); ?>
</div>
