<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\actions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Briz_Shortcodes\common\Helper;


/**
 * Links handlers.
 *
 * Действия ссылок карточки товара.
 *
 * @since 0.0.1
 * @author Ravil
 */
trait ProductLink {

	/**
	 * The opening tag of the link to the product page.
	 *
	 * Открывающий тег ссылки на страницу товара.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_product_image_link_open( $show_text ) {
		global $post, $product;
		$link = esc_url( get_the_permalink() );
		$title = __( get_the_title(), self::$lang_domain );
		$text = ( $show_text ) ? $title : '';

		echo apply_filters(
			'shortcode_briz_tax_template_product_image_link_open_html',
			sprintf( '<a href="%s" title="%s">%s', $link, $title, $text ),
			$post,
			$product,
			$link,
			$title,
			$text
		);
	}


	/**
	 * The closing tag of the link to the product page.
	 *
	 * Закрывающий тег ссылки на страницу товара.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_product_image_link_close() {
		global $post, $product;
		echo apply_filters(
			'shortcode_briz_tax_template_product_image_link_close_html',
			'</a>',
			$post,
			$product
		);
	}
}
