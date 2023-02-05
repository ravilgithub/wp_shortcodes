<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\actions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Briz_Shortcodes\common\Helper;

trait HoverContent {
	public function hover_content() {
		/**
		 * add_archive_product_caption_on_hover_content_container
		 */
		add_action(
			'woocommerce_after_shop_loop_item_title',
			[ $this, 'add_archive_product_caption_on_hover_content_container' ],
			99
		);

		/**
		 * add_archive_product_item_gallery
		 */
		add_action(
			'bri_add_archive_product_caption_on_hover_content_container_inner',
			[ $this, 'add_archive_product_item_gallery' ],
			10
		);
	}


	/**
	 * 
	 */
	public function add_archive_product_caption_on_hover_content_container() {
		global $post, $product;
?>
		<div class="caption-on-hover-content">
<?php
			do_action( 'bri_add_archive_product_caption_on_hover_content_container_inner' );
?>
		</div>
<?php
	}


	/**
	 * 
	 */
	public function add_archive_product_item_gallery() {
		global $post, $product;

		// Helper::debug( $post );			
		Helper::debug( $product );

		$html = '';
		$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
		$attachment_ids = $product->get_gallery_image_ids();

		if ( $post_thumbnail_id ) {
			array_unshift( $attachment_ids, $post_thumbnail_id );
		} else {
			$slide_img_src = esc_url( wc_placeholder_img_src() );
			$slide_img_alt_attr = esc_html__( 'Awaiting product image', 'woocommerce' );

			$html_placeholder = '<div data-lg-img-src="' . $slide_img_src . '" data-background-image="' . $slide_img_src . '" title="' . $slide_img_alt_attr . '" class="swiper-slide bri-archive-product-item-gallery__image--placeholder" >';
			$html_placeholder .= '<img src="' . $slide_img_src . '" alt="' . $slide_img_alt_attr . '" title="' . $slide_img_alt_attr . '" data-caption="' . $slide_img_alt_attr . '" />';
			$html_placeholder .= '</div>';

			// Мой фильтр - "bri_archive_product_item_gallery_placeholder_thumbnail_html"
			$html_placeholder = apply_filters( 'bri_archive_product_item_gallery_placeholder_thumbnail_html', $html_placeholder );
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
							$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
							// $full_size_image = wp_get_attachment_image_src( $attachment_id, 'shop_single' );
							//$thumbnail       = wp_get_attachment_image_src( $attachment_id, 'full' );
							$thumbnail       = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );

							$first_slide = ( 1 == ++$n ) ? 'active' : '';

							// Указывется при редактировании картинки в медиабиблиотеке
							$title = get_post_field( 'post_title', $attachment_id );
							$data_caption = get_post_field( 'post_excerpt', $attachment_id );

							$html_img = '<div data-lg-img-src="' . esc_url( $full_size_image[ 0 ] ) . '" class="swiper-slide bri-archive-product-item-gallery__image '  . $first_slide . '" title="' . $title . '" data-background-image="' . esc_url( $thumbnail[ 0 ] ) . '">';
							$html_img .= '<img src="' . esc_url( $thumbnail[ 0 ] ) . '" alt="' . $title . '" title="' . $title . '" data-caption="' . $data_caption . '" />';
					 		$html_img .= '</div>';

					 		$html .= apply_filters( 'bri_archive_product_item_gallery_image_thumbnail_html', $html_img, $attachment_id );
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
