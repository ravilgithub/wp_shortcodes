<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\actions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Briz_Shortcodes\common\Helper;


/**
 * Image handlers.
 *
 * Действия миниатюры карточки товара.
 *
 * @since 0.0.1
 * @author Ravil
 */
trait ProductImage {

	/**
	 * The opening tag of the product card thumbnail wrapper.
	 *
	 * Открывающий тег обёртки миниатюры карточки товара.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
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
	 * The closing tag of the product card thumbnail wrapper.
	 *
	 * Закрвающий тег обёртки миниатюры карточки товара.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
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
	 * Percentage discount on product price.
	 *
	 * Процент скидки на цену товара.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
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
	 * Message about the participation of goods in the sale.
	 *
	 * Сообщение об участии товара в распродаже.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_product_message() {
		global $post, $product;

		if ( ! $product->is_on_sale() )
			return false;

		echo apply_filters(
			'shortcode_briz_tax_template_product_message_html',
			sprintf(
				'<span class="product-message">%s</span>',
				esc_html__( 'Sale!', 'woocommerce' )
			),
			$post,
			$product
		);
	}


	/**
	 * Product card thumbnail.
	 *
	 * Миниатюра карточки товара.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
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
	 * Product card thumbnail preloader HTML element.
	 *
	 * HTML элемент сигнализирующий о загрузке карточки товара.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
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
