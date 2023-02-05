<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once 'actions/product_image.php';
require_once 'actions/product_link.php';
require_once 'actions/product_buttons_group.php';
require_once 'actions/product_caption.php';
require_once 'actions/hover_content.php';

use Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\actions\ {
	ProductImage,
	ProductLink,
	ProductButtonsGroup,
	ProductCaption,
	HoverContent,
};

trait Actions {
	use ProductImage,
	    ProductLink,
	    ProductButtonsGroup,
			ProductCaption,
	    HoverContent;

	protected function add_actions() {
		/**
		 * 1
		 * product_image_before
		 */
		add_action(
			'shortcode_briz_tax_product_image_before',
			[ $this, 'product_image_before' ],
			10
		);

		/**
		 * -1
		 * product_image_after
		 */
		add_action(
			'shortcode_briz_tax_product_image_after',
			[ $this, 'product_image_after' ],
			10
		);

		/**
		 * 2
		 * product_link_open
		 */
		add_action(
			'shortcode_briz_tax_product_link_open',
			[ $this, 'product_link_open' ],
			10
		);

		/**
		 * 3
		 * product_image_preloader
		 */
		add_action(
			'shortcode_briz_tax_product_image_preloader',
			[ $this, 'image_preloader' ],
			10
		);

		/**
		 * 
		 * product_sale
		 */
		add_action(
			'shortcode_briz_tax_product_sale_flash',
			[ $this, 'product_sale_flash' ],
			10
		);

		/**
		 * 
		 * product_message
		 */
		add_action(
			'shortcode_briz_tax_product_message',
			[ $this, 'product_message' ],
			10
		);

		/**
		 * 
		 * product_image
		 */
		add_action(
			'shortcode_briz_tax_product_image',
			[ $this, 'product_image' ],
			10
		);

		/**
		 * -2
		 * product_link_close
		 */
		add_action(
			'shortcode_briz_tax_product_link_close',
			[ $this, 'product_link_close' ],
			10
		);

		// ****************************************************

		/**
		 * 5
		 * product_buttons_group_before
		 */
		add_action(
			'shortcode_briz_tax_product_buttons_before',
			[ $this, 'product_buttons_group_before' ],
			10
		);

		/**
		 * -5
		 * product_buttons_group_after
		 */
		add_action(
			'shortcode_briz_tax_product_buttons_after',
			[ $this, 'product_buttons_group_after' ],
			10
		);

		/**
		 * 6
		 * product_add_to_cart
		 */
		add_action(
			'shortcode_briz_tax_product_add_to_cart',
			[ $this, 'product_add_to_cart' ],
			10
		);

		/**
		 * 7
		 * product_add_to_wishlist
		 */
		add_action(
			'shortcode_briz_tax_product_add_to_wishlist',
			[ $this, 'product_add_to_wishlist' ],
			10
		);

		/**
		 * 8
		 * product_add_to_compare
		 */
		add_action(
			'shortcode_briz_tax_product_add_to_compare',
			[ $this, 'product_add_to_compare' ],
			10
		);


		/**
		 * 9
		 * product_quickview
		 */
		add_action(
			'shortcode_briz_tax_product_quickview',
			[ $this, 'product_quickview' ],
			10
		);


		/**
		 * 
		 * product_caption_before
		 */
		add_action(
			'shortcode_briz_tax_product_caption_before',
			[ $this, 'product_caption_before' ],
			10
		);


		/**
		 * 
		 * product_caption_after
		 */
		add_action(
			'shortcode_briz_tax_product_caption_after',
			[ $this, 'product_caption_after' ],
			10
		);


		/**
		 * 
		 * product_caption_title
		 */
		add_action(
			'shortcode_briz_tax_product_caption_title',
			[ $this, 'product_caption_title' ],
			10
		);

		// ****************************************************
	}
}
