<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="uk-section uk-padding-remove-top">
    <div class="uk-container uk-padding-remove-horizontal@s">
        <?php do_action( 'woocommerce_before_cart' ); ?>
        <div class="steps uk-flex">
            <span class="steps__divider"></span>

            <div class="steps__step steps__step--active" data-step="cart">
                <span class="steps__step__icon">
                    <img src="<?= get_template_directory_uri() . '/assets/img/svg/steps/cart.svg' ?>" alt="cart"/>
                </span>
                <p class="steps__step__title"><?php _e( 'Koszyk', 'wctheme' ); ?></p>
            </div>
            <span class="steps__divider"></span>

            <div class="steps__step" data-step="login">
                <span class="steps__step__icon">
                    <img src="<?= get_template_directory_uri() . '/assets/img/svg/steps/login.svg' ?>" alt="login"/>
                </span>
                <p class="steps__step__title"><?php _e( 'Logowanie', 'wctheme' ); ?></p>
            </div>
            <span class="steps__divider"></span>

            <div class="steps__step" data-step="shipping">
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

        <form id="woocommerce-cart-form" class="form woocommerce-cart-form"
              action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
            <?php do_action( 'woocommerce_before_cart_table' ); ?>

            <table class="table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                <thead>
                <tr>
                    <th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
                    <th class="product-thumbnail">&nbsp;</th>
                    <th class="product-quantity"><?php esc_html_e( 'Liczba', 'wctheme' ); ?></th>
                    <th class="product-weight"><?php _e( 'Ilość osób', 'wctheme' ); ?></th>
                    <th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
                    <th class="product-remove">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                <?php
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                    $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                        ?>
                        <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?> uk-visible@s">
                            <td class="product-thumbnail">
                                <?php
                                $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                                if ( !$product_permalink ) {
                                    echo $thumbnail; // PHPCS: XSS ok.
                                } else {
                                    printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                                }
                                ?>
                            </td>

                            <td class="product-name">
                                <?php

                                $name = $_product->get_name();

                                if ( $cart_item['variation_id'] ) {
                                    $name = get_the_title( $cart_item['product_id'] );
                                }

                                if ( !$product_permalink ) {
                                    echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $name, $cart_item, $cart_item_key ) . '&nbsp;' );
                                } else {
                                    echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $name ), $cart_item, $cart_item_key ) );
                                }

                                do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                                // Meta data.
                                echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                                // Backorder notification.
                                if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                    echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                                }
                                ?>
                            </td>

                            <td class="product-quantity">
                                <?php
                                if ( $_product->is_sold_individually() ) {
                                    $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                } else {
                                    $product_quantity = woocommerce_quantity_input(
                                        array(
                                            'input_name' => "cart[{$cart_item_key}][qty]",
                                            'input_value' => $cart_item['quantity'],
                                            'max_value' => $_product->get_max_purchase_quantity(),
                                            'min_value' => '0',
                                            'product_name' => $_product->get_name(),
                                        ),
                                        $_product,
                                        false
                                    );
                                }

                                echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                                ?>
                            </td>

                            <td class="product-weight">
                                <?php
                                $weight = get_post_meta( $cart_item['variation_id'], 'attribute_pa_ilosc_osob', true );
                                if ( $weight ) {
                                    echo $weight;
                                } else {
                                    _e( '-', 'wctheme' );
                                }
                                ?>
                            </td>

                            <td class="product-subtotal">
                                <?php
                                echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                                ?>
                            </td>

                            <td class="product-remove">
                                <?php
                                echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    'woocommerce_cart_item_remove_link',
                                    sprintf(
                                        '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"></a>',
                                        esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                        esc_html__( 'Remove this item', 'woocommerce' ),
                                        esc_attr( $product_id ),
                                        esc_attr( $_product->get_sku() )
                                    ),
                                    $cart_item_key
                                );
                                ?>
                            </td>
                        </tr>
                        <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?> uk-hidden@s">
                            <td class="product-thumbnail">
                                <?php
                                $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                                if ( !$product_permalink ) {
                                    echo $thumbnail; // PHPCS: XSS ok.
                                } else {
                                    printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                                }
                                ?>
                            </td>

                            <td class="product-content">
                                <div class="product-name">
                                    <?php
                                    $name = $_product->get_name();

                                    if ( $cart_item['variation_id'] ) {
                                        $name = get_the_title( $cart_item['product_id'] );
                                    }
                                    ?>
                                    <?php
                                    if ( !$product_permalink ) {
                                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $name, $cart_item, $cart_item_key ) . '&nbsp;' );
                                    } else {
                                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $name ), $cart_item, $cart_item_key ) );
                                    }

                                    do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                                    // Meta data.
                                    echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                                    // Backorder notification.
                                    if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                                    }
                                    ?>
                                </div>

                                <div class="product-weight">
                                    <?php _e( 'Ilość osób', 'wctheme' ); ?>:
                                    <span>
                                        <?php
                                        $weight = get_post_meta( $cart_item['variation_id'], 'attribute_pa_ilosc_osob', true );
                                        if ( $weight ) {
                                            echo $weight;
                                        } else {
                                            _e( '-', 'wctheme' );
                                        }
                                        ?>
                                    </span>
                                </div>

                                <div class="product-quantity">
                                    <?php
                                    if ( $_product->is_sold_individually() ) {
                                        $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                    } else {
                                        $product_quantity = woocommerce_quantity_input(
                                            array(
                                                'input_name' => "cart[{$cart_item_key}][qty]",
                                                'input_value' => $cart_item['quantity'],
                                                'max_value' => $_product->get_max_purchase_quantity(),
                                                'min_value' => '0',
                                                'product_name' => $_product->get_name(),
                                            ),
                                            $_product,
                                            false
                                        );
                                    }

                                    echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                                    ?>
                                </div>

                                <div class="product-subtotal">
                                    <?php
                                    echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                                    ?>
                                </div>

                                <div class="product-remove">
                                    <?php
                                    echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                        'woocommerce_cart_item_remove_link',
                                        sprintf(
                                            '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"></a>',
                                            esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                            esc_html__( 'Remove this item', 'woocommerce' ),
                                            esc_attr( $product_id ),
                                            esc_attr( $_product->get_sku() )
                                        ),
                                        $cart_item_key
                                    );
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>

                <?php do_action( 'woocommerce_cart_contents' ); ?>

                <tr class="uk-hidden">
                    <td colspan="6" class="actions">
                        <button type="submit" class="button uk-hidden" name="update_cart"
                                value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

                        <?php do_action( 'woocommerce_cart_actions' ); ?>

                        <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                    </td>
                </tr>

                <?php do_action( 'woocommerce_after_cart_contents' ); ?>
                </tbody>
            </table>
            <?php do_action( 'woocommerce_after_cart_table' ); ?>
        </form>

        <?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

        <div class="cart-collaterals">
            <?php
            /**
             * Cart collaterals hook.
             *
             * @hooked woocommerce_cross_sell_display
             * @hooked woocommerce_cart_totals - 10
             */
            do_action( 'woocommerce_cart_collaterals' );
            ?>
        </div>

        <?php do_action( 'woocommerce_after_cart' ); ?>
    </div>
</section>
