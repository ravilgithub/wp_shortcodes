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

/**
 * Actions & Handlers.
 *
 * Действия и обработчики.
 *
 * @since 0.0.1
 * @author Ravil
 */
trait Actions {
	use ProductImage,
	    ProductLink,
	    ProductButtonsGroup,
	    ProductCaption,
	    ProductHoverContent;


	/**
	 * Actions list.
	 *
	 * Список действий.
	 *
	 * @see Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\actions as A
	 *
	 * @return Array - actions list
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	protected function get_actions_list() {
		$actions_list = [
			/**
			 * Begin Image
			 *
			 * @see A\ProductImage\shortcode_briz_tax_template_product_image_wrap_open
			 */
			'shortcode_briz_tax_before_product_image' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_product_image_wrap_open' ]],
			],


			/**
			 * Image / Begin Link
			 *
			 * @see A\ProductLink\shortcode_briz_tax_template_product_image_wrap_open
			 * @see A\ProductImage\shortcode_briz_tax_template_product_image_preloader
			 * @see A\ProductImage\shortcode_briz_tax_template_product_sale_flash
			 * @see A\ProductImage\shortcode_briz_tax_template_product_message
			 * @see A\ProductImage\shortcode_briz_tax_template_product_image
			 */
			'shortcode_briz_tax_before_product_image_link' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_product_image_link_open' ]],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_image_preloader' ], 15 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_sale_flash' ], 20 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_message' ], 25 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_image' ], 30 ],
			],


			/**
			 * Image / End Link
			 *
			 * @see A\ProductLink\shortcode_briz_tax_template_product_image_link_close
			 */
			'shortcode_briz_tax_after_product_image_link' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_product_image_link_close' ]],
			],


			/**
			 * Image / Begin Buttons
			 *
			 * @see A\ProductButtonsGroup\shortcode_briz_tax_template_product_buttons_wrap_open
			 * @see A\ProductButtonsGroup\shortcode_briz_tax_template_product_add_to_cart
			 * @see A\ProductButtonsGroup\shortcode_briz_tax_template_product_add_to_wishlist
			 * @see A\ProductButtonsGroup\shortcode_briz_tax_template_product_add_to_compare
			 * @see A\ProductButtonsGroup\shortcode_briz_tax_template_product_quickview
			 */
			'shortcode_briz_tax_before_product_buttons' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_product_buttons_wrap_open' ]],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_add_to_cart' ], 15 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_add_to_wishlist' ], 20 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_add_to_compare' ], 25 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_quickview' ], 30 ],
			],


			/**
			 * Image / End Buttons
			 *
			 * @see A\ProductButtonsGroup\shortcode_briz_tax_template_product_buttons_wrap_close
			 */
			'shortcode_briz_tax_after_product_buttons' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_product_buttons_wrap_close' ]],
			],


			/**
			 * End Images
			 *
			 * @see A\ProductImage\shortcode_briz_tax_template_product_image_wrap_open
			 */
			'shortcode_briz_tax_after_product_image' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_product_image_wrap_close' ]],
			],


			/**
			 * Begin Caption
			 *
			 * @see A\ProductCaption\shortcode_briz_tax_template_product_caption_wrap_open
			 * @see A\ProductCaption\shortcode_briz_tax_template_product_caption_title
			 * @see A\ProductCaption\shortcode_briz_tax_template_product_caption_rating
			 * @see A\ProductCaption\shortcode_briz_tax_template_product_caption_price
			 * @see A\ProductHoverContent\shortcode_briz_tax_template_product_hover_content_open_wrap
			 * @see A\ProductHoverContent\shortcode_briz_tax_template_product_hover_content_gallery
			 * @see A\ProductHoverContent\shortcode_briz_tax_template_product_hover_content_close_wrap
			 */
			'shortcode_briz_tax_before_product_caption' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_product_caption_wrap_open' ]],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_caption_title' ], 15 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_caption_rating' ], 20 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_caption_price' ], 25 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_hover_content_open_wrap' ], 30 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_hover_content_gallery' ], 35 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_product_hover_content_close_wrap' ], 40 ],
			],


			/**
			 * End Caption
			 *
			 * @see A\ProductCaption\shortcode_briz_tax_template_product_caption_wrap_close
			 */
			'shortcode_briz_tax_after_product_caption' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_product_caption_wrap_close' ]],
			],
		];

		return apply_filters( 'shortcode_briz_tax_product_actions_list', $actions_list );
	}


	/**
	 * Add actions.
	 *
	 * Прикрепляем указанную PHP функцию на указанный хук.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
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

				add_action( $tag, $callback, $priority, $accepted_args );
			}
		}
	}
}
