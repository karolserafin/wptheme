<?php
/**
 * Admin cancelled order email (plain text)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/plain/admin-cancelled-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woothemes.com/document/template-structure/
 * @author  	WooThemes
 * @package 	WooCommerce/Templates/Emails/Plain
 * @version 	2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo "= " . $email_heading . " =\n\n";

echo __( 'Dzień dobry!', 'wctheme' ) . " =\n\n";

echo __( 'Dziękujemy za zamówienie w wctheme Patisserie & Chocolaterie. Właśnie szykujemy Twoje zamówienie! Wkrótce powiadomimy Cię o dalszych krokach. Mamy nadzieję, że będzie pysznie!', 'wctheme' ) . " \n\n";

echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo __( 'Zespół wctheme', 'wctheme' );
