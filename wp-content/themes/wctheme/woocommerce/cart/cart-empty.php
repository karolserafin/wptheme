<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>

	<div class="uk-container uk-container-large uk-margin-large-top uk-margin-large-bottom">
        <div class="woocommerce-order">

            <h2 class="uk-text-center"><?php esc_html_e( 'Twój koszyk jest pusty.', 'wctheme' ); ?></h2>

			<p class="return-to-shop uk-text-center">
				<a class="button checkout-button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
					<?php esc_html_e( 'Return to shop', 'woocommerce' ); ?>
				</a>
			</p>

        </div>
    </div>
	
<?php endif; ?>
