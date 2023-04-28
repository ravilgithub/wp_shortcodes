<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once 'filters/plugin_woocommerce_template.php';

use Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\filters\ {
	PluginWoocommerceTemplate,
};

use Briz_Shortcodes\common\Helper;

/**
 * Filters & Handlers.
 *
 * Фильтры и обработчики.
 *
 * @since 0.0.1
 * @author Ravil
 */
trait Filters {
	use PluginWoocommerceTemplate;

	/**
	 * Filters list.
	 *
	 * Список фильтров.
	 *
	 * @see Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\filters as F
	 *
	 * @return Array - filters list
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	protected function get_filters_list() {
		$filters_list = [
			/**
			 * Begin Image
			 *
			 * @see F\PluginWoocommerceTemplate\set_template_path
			 */
			'woocommerce_locate_template' => [
				[[ __CLASS__, 'set_template_path' ], 10, 3],
			],
		];

		return apply_filters( 'shortcode_briz_tax_product_filters_list', $filters_list );
	}


	/**
	 * Add Filters.
	 *
	 * Прикрепляем указанную PHP функцию на указанный хук.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	protected function add_filters() {
		$defaults = [ null, 10, 1 ];

		foreach ( $this->get_filters_list() as $tag => $items ) {
			foreach ( $items as $item ) {
				list(
					$callback,
					$priority,
					$accepted_args
				) = array_replace( $defaults, $item );

				if ( empty( $callback ) || has_action( $tag, $callback ) )
					continue;

				add_filter( $tag, $callback, $priority, $accepted_args );
			}
		}
	}
}
