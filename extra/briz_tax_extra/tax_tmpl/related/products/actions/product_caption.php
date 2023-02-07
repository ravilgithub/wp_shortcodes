<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\actions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Briz_Shortcodes\common\Helper;

trait ProductCaption {
	/**
	 * 
	 */
	public function product_caption_before() {
		global $post, $product;
		echo '<div class="caption">';
	}


	/**
	 * 
	 */
	public function product_caption_after() {
		global $post, $product;
		echo '</div>';
	}


	/**
	 * 
	 */
	public function product_caption_title() {
		global $post, $product;

		$link = esc_url( get_the_permalink() );
		$title = __( get_the_title(), $this->lang_domain );

		echo apply_filters(
			'shortcode_briz_tax_product_caption_title_html',
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
	 * @param Boolean $hide_empty - спрятать нулевой рейтинг? Default: false.
	 */
	public function product_caption_rating( $hide_empty ) {
		global $post, $product;

		if ( ! wc_review_ratings_enabled() || $hide_empty ) {
			return;
		}

		$rating_wrapper_open = apply_filters(
			'shortcode_briz_tax_product_caption_rating_wrapper_open_html',
			'<div class="star-rating-wrap after-star-rating grid">',
			$post,
			$product,
			$hide_empty
		);

		$rating_wrapper_close = apply_filters(
			'shortcode_briz_tax_product_caption_rating_wrapper_close_html',
			'</div>',
			$post,
			$product,
			$hide_empty
		);

		echo $rating_wrapper_open . wc_get_rating_html( $product->get_average_rating() ) . $rating_wrapper_close;
	}


	/**
	 * 
	 */
	public function product_caption_price() {
		global $post, $product;

		if ( ! $price_html = $product->get_price_html() )
			return false;

		$price_wrapper_open = apply_filters(
			'shortcode_briz_tax_product_caption_price_wrapper_open_html',
			'<span class="price"><span class="price-inner-wrap">',
			$post,
			$product
		);

		$price_wrapper_close = apply_filters(
			'shortcode_briz_tax_product_caption_price_wrapper_close_html',
			'</span></span>',
			$post,
			$product
		);

		echo $price_wrapper_open, $price_html, $price_wrapper_close;
	}
}
?>
