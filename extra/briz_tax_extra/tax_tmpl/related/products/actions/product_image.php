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
	public function product_image_before() {
		global $post, $product;
		echo '<div class="image-wrap">';
	}


	/**
	 * 
	 */
	public function product_image_after() {
		global $post, $product;
		echo '</div>';
	}


	/**
	 * 
	 */
	public function product_sale_flash() {
		global $post, $product;
		
		if ( ! $product->is_on_sale() )
			return false;

		$text = esc_html__( 'Sale!', 'woocommerce' );
		$class = 'product-message';

		$regular_price = floatval( $product->get_regular_price() );
		$sale_price = floatval( $product->get_sale_price() );

		if ( ! $regular_price )
			return false;

		$text = floor( ( $regular_price - $sale_price ) / $regular_price * 100 );
		$text = '-' . $text . '%';

		echo apply_filters( 'shortcode_briz_tax_product_sale_flash_html', '<span class="onsale">' . $text . '</span>', $post, $product );
	}


	/**
	 * 
	 */
	public function product_message() {
		global $post, $product;

		echo apply_filters( 'shortcode_briz_tax_product_message_html', '<span class="product-message">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product );
	}


	/**
	 * 
	 */
	public function product_image() {
		global $post, $product;
		$size = 'woocommerce_single';
		$attr = [ 'class' => 'img-responsive' ];

		echo apply_filters(
			'shortcode_briz_tax_product_image_html',
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
	public function image_preloader() {
		global $post, $product;
		echo '<div class="archive-product-preloader-box"></div>';
	}
}
