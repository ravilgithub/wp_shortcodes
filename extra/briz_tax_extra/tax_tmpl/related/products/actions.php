<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once 'actions/product_image.php';
require_once 'actions/product_link.php';
require_once 'actions/product_buttons_group.php';
require_once 'actions/product_caption.php';
require_once 'actions/product_hover_content.php';

use Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\actions\ {
	ProductImage,
	ProductLink,
	ProductButtonsGroup,
	ProductCaption,
	ProductHoverContent,
};

use Briz_Shortcodes\common\Helper;

trait Actions {
	use ProductImage,
	    ProductLink,
	    ProductButtonsGroup,
	    ProductCaption,
	    ProductHoverContent;

	/**
	 * 
	 */
	protected function get_actions_list() {
		$actions_list = [
			// Begin Image
			'shortcode_briz_tax_before_product_image' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_product_image_wrap_open' ]],
			],

			// Begin Image / Link
			'shortcode_briz_tax_before_product_image_link' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_product_image_link_open' ]],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_image_preloader' ], 15 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_sale_flash' ], 20 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_message' ], 25 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_image' ], 30 ],
			],
			'shortcode_briz_tax_after_product_image_link' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_product_image_link_close' ]],
			],
			// End Image / Link

			// Begin Image / Buttons
			'shortcode_briz_tax_before_product_buttons' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_product_buttons_wrap_open' ]],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_add_to_cart' ], 15 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_add_to_wishlist' ], 20 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_add_to_compare' ], 25 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_quickview' ], 30 ],
			],
			'shortcode_briz_tax_after_product_buttons' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_product_buttons_wrap_close' ]],
			],
			// End Image / Buttons

			'shortcode_briz_tax_after_product_image' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_product_image_wrap_close' ]],
			],
			// End Images


			// Begin Caption
			'shortcode_briz_tax_before_product_caption' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_product_caption_wrap_open' ]],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_caption_title' ], 15 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_caption_rating' ], 20 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_caption_price' ], 25 ],

			// Before Caption / Hover Content
				[[ __CLASS__, 'shortcode_briz_tax_template_product_hover_content_open_wrap' ], 30 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_hover_content_gallery' ], 35 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_hover_content_close_wrap' ], 40 ],
			],
			// End Caption / Hover Content

			'shortcode_briz_tax_after_product_caption' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_product_caption_wrap_close' ]],
			],
			// End Caption
		];

		return apply_filters( 'shortcode_briz_tax_product_actions_list', $actions_list );
	}


	/**
	 * 
	 */
	protected function add_actions() {
		$defaults = [ null, 10, 1 ];

		foreach ( $this->get_actions_list() as $tag => $items ) {
			foreach ( $items as $item ) {
				list(
					$callback,
					$priority,
					$accepted_args
				) = array_replace( $defaults, $item );

				if ( empty( $callback ) || has_action( $tag, $callback ) )
					continue;

				$priority = $priority ?: 10;
				$accepted_args = $accepted_args ?: 1;
				add_action( $tag, $callback, $priority, $accepted_args );
			}
		}
	}
}
