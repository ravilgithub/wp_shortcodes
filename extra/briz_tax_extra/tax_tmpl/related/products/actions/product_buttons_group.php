<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\actions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Briz_Shortcodes\common\Helper;


/**
 * Buttons handlers.
 *
 * Действия кнопок карточки товара.
 *
 * @since 0.0.1
 * @author Ravil
 */
trait ProductButtonsGroup {

	/**
	 * The opening tag of the product card buttons wrapper.
	 *
	 * Открывающий тег обёртки кнопок карточки товара.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_product_buttons_wrap_open() {
		global $post, $product;
		echo apply_filters(
			'shortcode_briz_tax_template_product_buttons_wrap_open_html',
			'<div class="button-group">',
			$post,
			$product
		);
	}


	/**
	 * The opening tag of the product card thumbnail wrapper.
	 *
	 * The closing tag of the product card buttons wrapper.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_product_buttons_wrap_close() {
		global $post, $product;
		echo apply_filters(
			'shortcode_briz_tax_template_product_buttons_wrap_close_html',
			'</div>',
			$post,
			$product
		);
	}


	/**
	 * Add product to cart button.
	 *
	 * Кнопока добавления товара в корзину.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_product_add_to_cart( $args = [] ) {
		global $post, $product;

		if ( $product ) {
			$defaults = array(
				'quantity'   => 1,
				'class'      => implode(
					' ',
					array_filter(
						array(
							'button',
							wc_wp_theme_get_element_class_name( 'button' ), // escaped in the template.
							'product_type_' . $product->get_type(),
							$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
							$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
						)
					)
				),
				'attributes' => array(
					'data-product_id'  => $product->get_id(),
					'data-product_sku' => $product->get_sku(),
					'aria-label'       => $product->add_to_cart_description(),
					'rel'              => 'nofollow',
				),
			);

			$args = apply_filters( 'shortcode_briz_tax_template_product_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

			if ( isset( $args['attributes']['aria-label'] ) ) {
				$args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
			}

			echo apply_filters(
				'shortcode_briz_tax_template_product_add_to_cart_html', // WPCS: XSS ok.
				sprintf(
					'<div class="woocommerce_loop_add_to_cart_link_wrap"><a href="%s" data-quantity="%s" class="%s" %s>%s</a></div>',
					esc_url( $product->add_to_cart_url() ),
					esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
					esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
					isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
					esc_html( $product->add_to_cart_text() )
				),
				$post,
				$product,
				$args
			);
		}
	}


	/**
	 * Add product to wishlist.
	 *
	 * Кнопока добавления товара в избранное.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_product_add_to_wishlist() {
		if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
			echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
		}
	}


	/**
	 * Add product to compare.
	 *
	 * Кнопока добавления товара в список сравнения товаров.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_product_add_to_compare() {
		global $yith_woocompare;
		global $post, $product;

		if ( ! isset( $yith_woocompare ) )
			return false;

		$button_text = get_option( 'yith_woocompare_button_text', __( 'Compare', 'yith-woocommerce-compare' ) );
		$product_id = $product->get_id();

		$class = '';
		if (
			isset( $yith_woocompare->obj ) &&
			! empty( $yith_woocompare->obj->products_list )
		) {
			if ( in_array( $product_id, $yith_woocompare->obj->products_list ) )
				$class = ' added';
		}

		echo apply_filters(
			'shortcode_briz_tax_template_product_add_to_compare_html',
			sprintf(
				'<div class="woocommerce product compare-button"><a href="/clear/?action=yith-woocompare-view-table&iframe=yes" class="compare button%3$s" data-product_id="%1$d" rel="nofollow">%2$s</a></div>',
				$product_id,
				$button_text,
				$class
			),
			$post,
			$product,
			$yith_woocompare
		);
	}


	/**
	 * Product quickview.
	 *
	 * Быстрый просмотр/заказ товара.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_product_quickview() {
		global $post, $product;
		$product_id = esc_attr( $product->get_id() );
		$post_type = get_post_type( $product_id );
		$style = ( 'product_variation' === $post_type ) ? 'visibility: hidden;' : '';
		$text = __( 'Quick view', 'woocommerce' );

		echo apply_filters(
			'shortcode_briz_tax_template_product_quickview_html',
			sprintf(
				'<div class="button-quickview bri-%1$s" style="%3$s"><a class="quickview button" rel="nofollow" href="#quickview-%2$d" data-product-id="%2$d" data-post-type="%1$s">%4$s</a></div>',
				$post_type,
				$product_id,
				$style,
				$text
			),
			$post,
			$product
		);
	}
}
