<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\actions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Briz_Shortcodes\common\Helper;


/**
 * Additional content handlers when hovering over a product card.
 *
 * Действия дополнительного контента при наведении на карточку товара.
 *
 * @since 0.0.1
 * @author Ravil
 */
trait ProductHoverContent {

	/**
	 * The opening wrapper tag for additional content when hovering over a product card.
	 *
	 * Открывающий тег обёртки дополнительного контента при наведении на карточку товара.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_product_hover_content_open_wrap() {
		global $post, $product;

		echo apply_filters(
			'shortcode_briz_tax_template_product_hover_content_open_wrap_html',
			'<div class="caption-on-hover-content">',
			$post,
			$product
		);
	}


	/**
	 * The closing wrapper tag for additional content when hovering over a product card.
	 *
	 * Закрывающий тег обёртки дополнительного контента при наведении на карточку товара.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_product_hover_content_close_wrap() {
		global $post, $product;

		echo apply_filters(
			'shortcode_briz_tax_template_product_hover_content_close_wrap_html',
			'</div>',
			$post,
			$product
		);
	}


	/**
	 * Additional content gallery slides.
	 *
	 * Слайды галереи дополнительного контента товара.
	 *
	 * @return String - HTML разметка слайдов галереи дополнительного контента товара.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function gallery_slides( $post, $product, $attachment_ids ) {
		$slides = '';

		foreach ( $attachment_ids as $k => $attachment_id ) {
			$first_slide = ( $k == 0 ) ? 'active' : '';

			/**
			 * Фиксированный размер из адинки:
			 *  "woocommerce" -> "настройки" -> отображение:
			 *	 1. Изображения каталога - "shop_catalog"
			 *	 2. Изображение единичного товара - "shop_single"
			 *	 3. Миниатюра товара - "shop_thumbnail"
			 */
			$full_size_image = esc_url( wp_get_attachment_image_src( $attachment_id, 'full' )[ 0 ] );
			list( $thumbnail, $thumbnail_width, $thumbnail_height ) = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
			$thumbnail = esc_url( $thumbnail );
			$aspect_ratio = ( $thumbnail_height !== 0 ) ? $thumbnail_width / $thumbnail_height : 'auto';

			// Указывется при редактировании картинки в медиабиблиотеке
			$title = get_post_field( 'post_title', $attachment_id );
			$data_caption = get_post_field( 'post_excerpt', $attachment_id );

			$slides .= apply_filters(
				'shortcode_briz_tax_template_product_hover_content_gallery_slide_html',
				sprintf(
					'<div data-lg-img-src="%1$s" class="swiper-slide bri-archive-product-item-gallery__image %2$s" title="%3$s" data-background-image="%4$s"><img src="%4$s" alt="%3$s" title="%3$s" data-caption="%5$s" style="aspect-ratio:%6$s;" /></div>',
					$full_size_image,
					$first_slide,
					$title,
					$thumbnail,
					$data_caption,
					$aspect_ratio
				),
				$post,
				$product,
				$attachment_id
			);
		}

		return $slides;
	}


	/**
	 * Product Additional Content Gallery.
	 *
	 * Галерея дополнительного контента товара.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_product_hover_content_gallery() {
		global $post, $product;

		$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
		$attachment_ids = $product->get_gallery_image_ids();

		// Нет картинок для слайдера.
		if ( empty( $attachment_ids ) )
			return false;

		if ( count( $attachment_ids ) == 1 ) {
			// Если картинка одна и она такая же как миниатюра товара, то слайдер не нужен.
			if ( $attachment_ids[ 0 ] == $post_thumbnail_id ) {
				return false;
			} else {
				array_unshift( $attachment_ids, $post_thumbnail_id );
			}
		}
		elseif ( ! in_array( $post_thumbnail_id, $attachment_ids ) ) {
			array_unshift( $attachment_ids, $post_thumbnail_id );
		}

		echo apply_filters(
			'shortcode_briz_tax_template_product_hover_content_gallery_html',
			sprintf(
				'<div class="bri-archive-product-item-gallery"><div class="swiper"><div class="swiper-wrapper">%s</div></div><div class="swiper-button-prev-custom"></div><div class="swiper-button-next-custom"></div></div>',
				self::gallery_slides( $post, $product, $attachment_ids )
			),
			$post,
			$product,
			$attachment_ids
		);
	}
}
