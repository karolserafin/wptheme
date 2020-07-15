<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php _e( 'Dzień dobry! :) Dziękujemy za rejestrację w sklepie wctheme Patisserie & Chocolaterie! :) Teraz możesz wygodnie zamawiać nasze ciastka, torty, lody, czekolady i inne słodkości. Dzięki rejestracji masz też szybki podgląd do historii zamówień, więc możesz szybko wrócić do ulubionych smaków!', 'wctheme' ); ?></p>

<p><?php _e( 'Smacznego!', 'wctheme' ) ?></p>
<p><?php _e( 'Zespół wctheme', 'wctheme' ) ?></p>

<?php

do_action( 'woocommerce_email_footer', $email );
