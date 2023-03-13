<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\actions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Briz_Shortcodes\common\Helper;

trait ProductImage {
	/**
	 * 
	 */
	public static function shortcode_briz_tax_template_product_image_wrap_open() {
		global $post, $product;
		echo apply_filters(
			'shortcode_briz_tax_template_product_image_wrap_open_html',
			'<div class="image-wrap">',
			$post,
			$product
		);
	}


	/**
	 * 
	 */
	public static function shortcode_briz_tax_template_product_image_wrap_close() {
		global $post, $product;
		echo apply_filters(
			'shortcode_briz_tax_template_product_image_wrap_close_html',
			'</div>',
			$post,
			$product
		);
	}


	/**
	 * 
	 */
	public static function shortcode_briz_tax_template_product_sale_flash() {
		global $post, $product;

		if ( ! $product->is_on_sale() )
			return false;

		$regular_price = floatval( $product->get_regular_price() );
		if ( ! $regular_price )
			return false;

		$sale_price = floatval( $product->get_sale_price() );
		$discount = floor( ( $regular_price - $sale_price ) / $regular_price * 100 );

		echo apply_filters(
			'shortcode_briz_tax_template_product_sale_flash_html',
			sprintf(
				'<span class="onsale">-%s%%</span>',
				$discount
			),
			$post,
			$product,
			$discount
		);
	}


	/**
	 * 
	 */
	public static function shortcode_briz_tax_template_product_message() {
		global $post, $product;
		echo apply_filters(
			'shortcode_briz_tax_template_product_message_html',
			'<span class="product-message">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>',
			$post,
			$product
		);
	}


	/**
	 * 
	 */
	public static function shortcode_briz_tax_template_product_image() {
		global $post, $product;
		$size = 'woocommerce_single';
		$attr = [ 'class' => 'img-responsive' ];

		echo apply_filters(
			'shortcode_briz_tax_template_product_image_html',
			sprintf(
				'<div class="product-image">%s</div>',
				woocommerce_get_product_thumbnail( $size, $attr, false )
			),
			$post,
			$product,
			$size,
			$attr
		);
	}


	/**
	 * 
	 */
	public static function shortcode_briz_tax_template_product_image_preloader() {
		global $post, $product;
		echo apply_filters(
			'shortcode_briz_tax_template_product_image_preloader_html',
			'<div class="archive-product-preloader-box"></div>',
			$post,
			$product
		);
	}
}
