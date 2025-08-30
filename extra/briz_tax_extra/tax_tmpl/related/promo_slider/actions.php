<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\promo_slider;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once 'actions/slide.php';

use Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\promo_slider\actions\ {
	Slide,
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
	use Slide;


	/**
	 * Actions list.
	 *
	 * Список действий.
	 *
	 * @see Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\promo_slider\actions as A
	 *
	 * @return Array - actions list
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	protected function get_actions_list() {
		$actions_list = [
			/**
			 * Before Content
			 *
			 * @see A\Slide\shortcode_briz_tax_template_slide_inner_open
			 */
			'shortcode_briz_tax_promo_slide_before_content' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_slide_inner_open' ], 10, 4 ],
			],


			/**
			 * Content
			 *
			 * @see A\Slide\shortcode_briz_tax_template_slide_content
			 * @see A\Slide\shortcode_briz_tax_template_slide_free_elements
			 */
			'shortcode_briz_tax_promo_slide_content' => [
				[[ __CLASS__, 'shortcode_briz_tax_template_slide_content' ], 10, 4 ],
				[[ __CLASS__, 'shortcode_briz_tax_template_slide_free_elements' ], 10, 4 ],
			],


            /**
			 * After Content
			 *
			 * @see A\Slide\shortcode_briz_tax_template_slide_inner_close
			 */
			'shortcode_briz_tax_promo_slide_after_content' => [

				[[ __CLASS__, 'shortcode_briz_tax_template_slide_inner_close' ], 10, 4 ],
			],
		];

		return apply_filters( 'shortcode_briz_tax_promo_slide_actions_list', $actions_list );
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
