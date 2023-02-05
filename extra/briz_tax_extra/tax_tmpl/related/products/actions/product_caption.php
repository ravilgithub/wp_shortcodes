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
}
