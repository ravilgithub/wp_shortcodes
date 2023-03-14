<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\actions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Briz_Shortcodes\common\Helper;


/**
 * 
 */
trait ProductCaption {

	/**
	 * The opening tag of the product card caption wrapper.
	 *
	 * Открывающий тег обёртки заголовка карточки товара.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_product_caption_wrap_open() {
		global $post, $product;

		echo apply_filters(
			'shortcode_briz_tax_template_product_caption_wrap_open_html',
			'<div class="caption">',
			$post,
			$product
		);
	}


	/**
	 * The closing tag of the product card caption wrapper.
	 *
	 * Закрывающий тег обёртки заголовка карточки товара.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_product_caption_wrap_close() {
		global $post, $product;

		echo apply_filters(
			'shortcode_briz_tax_template_product_caption_wrap_close_html',
			'</div>',
			$post,
			$product
		);
	}


	/**
	 * Title of the product card.
	 *
	 * Заголовок карточки товара.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_product_caption_title() {
		global $post, $product;

		$link = esc_url( get_the_permalink() );
		$title = __( get_the_title(), self::$lang_domain );

		echo apply_filters(
			'shortcode_briz_tax_template_product_caption_title_html',
			sprintf(
				'<h4><a href="%1$s" title="%2$s">%2$s</a></h4>',
				$link,
				$title
			),
			$post,
			$product
		);
	}


	/**
	 * Product rating HTML markup.
	 *
	 * HTML разметка рейтинга товара.
	 *
	 * @return String - HTML разметка рейтинга товара.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function rating_html() {
		global $post, $product;

		$rating = $product->get_average_rating();
		$title = sprintf( esc_attr__( 'Rated %s out of ', 'woocommerce' ), $rating );
		$style_width = ( $rating / 5 ) * 100;
		$text = esc_html__( 'out of 5', 'woocommerce' );

		return sprintf(
			'<div class="star-rating" title="%s"><span style="width:%s%%;"><strong class="rating">%s</strong>%s</span></div>',
			$title,
			$style_width,
			$rating,
			$text
		);
	}


	/**
	 * Product rating.
	 *
	 * Рейтинг товара.
	 *
	 * @return String - Рейтинг товара.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_product_caption_rating() {
		global $post, $product;

		if ( ! wc_review_ratings_enabled() ) {
			return;
		}

		$rating_html = self::rating_html();

		echo apply_filters(
			'shortcode_briz_tax_template_product_caption_rating_html',
			sprintf(
				'<div class="star-rating-wrap after-star-rating grid">%s</div>',
				$rating_html
			),
			$post,
			$product,
			$rating_html
		);
	}


	/**
	 * Product price.
	 *
	 * Product price.
	 *
	 * @return String - HTML разметка цены товара.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_product_caption_price() {
		global $post, $product;

		if ( ! $price_html = $product->get_price_html() )
			return false;

		echo apply_filters(
			'shortcode_briz_tax_template_product_caption_price_html',
			sprintf(
				'<span class="price"><span class="price-inner-wrap">%s</span></span>',
				$price_html
			),
			$post,
			$product
		);
	}
}
