<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\actions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Briz_Shortcodes\common\Helper;

trait ProductLink {
	/**
	 * 
	 */
	public function product_link_open( $show_text ) {
		global $post, $product;
		$link = esc_url( get_the_permalink() );
		$title = __( get_the_title(), $this->lang_domain );
		$text = ( $show_text ) ? $title : '';
		$format = '<a href="%s" title="%s">%s';
		printf( $format, $link, $title, $text );
	}


	/**
	 * 
	 */
	public function product_link_close() {
		global $post, $product;
		echo '</a>';
	}
}
