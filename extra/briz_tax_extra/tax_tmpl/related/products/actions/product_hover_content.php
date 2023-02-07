<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\actions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Briz_Shortcodes\common\Helper;

trait ProductHoverContent {
	/**
	 * 
	 */
	public function product_hover_content_before() {
		global $post, $product;

		echo apply_filters(
			'shortcode_briz_tax_product_hover_content_before_html',
			'<div class="caption-on-hover-content">',
			$post,
			$product
		);
	}


	/**
	 * 
	 */
	public function product_hover_content_after() {
		global $post, $product;

		echo apply_filters(
			'shortcode_briz_tax_product_hover_content_after_html',
			'</div>',
			$post,
			$product
		);
	}


	/**
	 * 
	 */
	public function product_hover_content_item_gallery() {
		global $post, $product;

		$html = '';
		$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
		$attachment_ids = $product->get_gallery_image_ids();

		if ( $post_thumbnail_id ) {
			array_unshift( $attachment_ids, $post_thumbnail_id );
		} else {
			$slide_img_src = esc_url( wc_placeholder_img_src() );
			$slide_img_alt_attr = esc_html__( 'Awaiting product image', 'woocommerce' );

			$html_placeholder = sprintf(
				'<div data-lg-img-src="%1$s" data-background-image="%1$s" title="%2$s" class="swiper-slide bri-archive-product-item-gallery__image--placeholder" ><img src="%1$s" alt="%2$s" title="%2$s" data-caption="%2$s" /></div>',
				$slide_img_src,
				$slide_img_alt_attr
			);

			// Мой фильтр - "bri_archive_product_item_gallery_placeholder_thumbnail_html"
			$html_placeholder = apply_filters(
				'bri_archive_product_item_gallery_placeholder_thumbnail_html',
				$html_placeholder
			);
		}
?>
		<div class="bri-archive-product-item-gallery">
			<div class="swiper">
				<div class="swiper-wrapper">
<?php
					if ( ! empty( $attachment_ids ) ) {
						$n = 0;

						foreach ( $attachment_ids as $attachment_id ) {

							/*	Фиксированный размер из адинки "woocommerce" -> "настройки" -> отображение:
									1. Изображения каталога - "shop_catalog"
									2. Изображение единичного товара - "shop_single"
									3. Миниатюра товара - "shop_thumbnail"
							*/
							$full_size_image = esc_url( wp_get_attachment_image_src( $attachment_id, 'full' )[ 0 ] );
							$thumbnail = esc_url( wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' )[ 0 ] );

							$first_slide = ( 1 == ++$n ) ? 'active' : '';

							// Указывется при редактировании картинки в медиабиблиотеке
							$title = get_post_field( 'post_title', $attachment_id );
							$data_caption = get_post_field( 'post_excerpt', $attachment_id );

							$html_img = sprintf(
								'<div data-lg-img-src="%1$s" class="swiper-slide bri-archive-product-item-gallery__image %2$s" title="%3$s" data-background-image="%4$s"><img src="%4$s" alt="%3$s" title="%3$s" data-caption="%5$s" /></div>',
								$full_size_image,
								$first_slide,
								$title,
								$thumbnail,
								$data_caption
							);

							$html .= apply_filters(
								'bri_archive_product_item_gallery_image_thumbnail_html',
								$html_img,
								$attachment_id
							);
						}

						if ( ! $post_thumbnail_id ) {
							$html = $html_placeholder . $html;
						}
					} else {
						$html = $html_placeholder;
					}

					echo $html;
?>
				</div>
			</div>
			<div class="swiper-button-prev-custom"></div>
			<div class="swiper-button-next-custom"></div>
			<!-- <div class="swiper-pagination-custom"></div> -->
		</div>
<?php
	}
}
