<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\promo_slider\actions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Briz_Shortcodes\common\Helper;


/**
 * Promo Slide Content Actions.
 *
 * Действия контента промо слайда.
 *
 * @since 0.0.1
 * @author Ravil
 */
trait Slide {

	/**
	 * Opening tag of promo slide content wrapper.
	 *
	 * Открывающий тег обёртки контента промо слайда.
	 *
	 * @param String $screen        - позиция контента.
	 *                                Default: right.
	 *                                Accepts: left | center | right.
	 * @param Array $opts           - мета поля записи.
	 * @param WP_Query Object $opts - объект запроса.
	 * @param String $lang_domain   - id перевода шорткода.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_slide_inner_open( $screen, $opts, $query, $lang_domain ) {
		global $post;

		switch( $screen ) {
			case 'left': $slide_inner_modifier = 'left'; break;
			case 'center': $slide_inner_modifier = 'center'; break;
			default: $slide_inner_modifier = 'evenly';
		}

		echo apply_filters(
			'shortcode_briz_tax_template_slide_inner_open_html',
			sprintf(
				'<div class="promo-slider__slide-inner promo-slider__slide-inner--%s">',
				esc_attr( $slide_inner_modifier )
			),
			$post,
			$screen,
			$opts,
			$query,
			$lang_domain
		);
	}


	/**
	 * Closing tag of promo slide content wrapper.
	 *
	 * Закрывающий тег обёртки контента промо слайда.
	 *
	 * @param String $screen        - позиция контента.
	 *                                Default: right.
	 *                                Accepts: left | center | right.
	 * @param Array $opts           - мета поля записи.
	 * @param WP_Query Object $opts - объект запроса.
	 * @param String $lang_domain   - id перевода шорткода.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_slide_inner_close( $screen, $opts, $query, $lang_domain ) {
		global $post;

		echo apply_filters(
			'shortcode_briz_tax_template_slide_inner_close_html',
			'</div>',
			$post,
			$screen,
			$opts,
			$query,
			$lang_domain
		);
	}


	/**
	 * Slide content.
	 *
	 * Контент слайда.
	 *
	 * @param String $screen        - позиция контента.
	 *                                Default: right.
	 *                                Accepts: left | center | right.
	 * @param Array $opts           - мета поля записи.
	 * @param WP_Query Object $opts - объект запроса.
	 * @param String $lang_domain   - id перевода шорткода.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_slide_content( $screen, $opts, $query, $lang_domain ) {
		global $post;

		$post_content = get_the_content( '' );
		$content_image_src = '';
		$content_image_animation = 'fadeIn';
		$content_image_delay = 0;
		$content_image_duration = 0;

		if ( is_array( $opts ) ) {
			if ( // проверить на наличие image
				! empty( $image = $opts[ 'content_image' ][ 'image' ] ) &&
				$attach_id = (int) json_decode( $image )[0]
			) {
				$content_image_src = esc_url( wp_get_attachment_image_url( $attach_id, 'full' ) );
				$img_title = esc_attr__( get_the_title( $attach_id ), $lang_domain );
				$img_alt = esc_attr__( get_post_meta( $attach_id, '_wp_attachment_image_alt', true ), $lang_domain );
			}

			$content_image_animation = $opts[ 'content_image' ][ 'animation' ] ?? $content_image_animation;
			$content_image_delay = $opts[ 'content_image' ][ 'delay' ] ?? $content_image_delay;
			$content_image_duration = $opts[ 'content_image' ][ 'duration' ] ?? $content_image_duration;
		}

		include_once apply_filters(
			'shortcode_briz_tax_template_slide_content_html_path',
			PLUGIN_PATH . "extra/briz_tax_extra/tax_tmpl/related/promo_slider/slide_content/$screen.php",
			$post,
			$screen,
			$opts,
			$query,
			$lang_domain
		);
	}


	/**
	 * Free elements.
	 *
	 * Свободные элементы.
	 *
	 * @param String $screen        - позиция контента.
	 *                                Default: right.
	 *                                Accepts: left | center | right.
	 * @param Array $opts           - мета поля записи.
	 * @param WP_Query Object $opts - объект запроса.
	 * @param String $lang_domain   - id перевода шорткода.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function shortcode_briz_tax_template_slide_free_elements( $screen, $opts, $query, $lang_domain ) {
		global $post;

		$free_images = [];
		if ( is_array( $opts ) ) {
			$free_images = $opts[ 'free_images' ] ?? $free_images;
		}

		foreach ( $free_images as $free_image ) {
			if ( // проверить на наличие src
				empty( $image = json_decode( $free_image[ 'image' ] ) ) ||
				! $attach_id = (int) $image[0]
			) continue;

			echo apply_filters(
				'shortcode_briz_tax_template_slide_free_elements_html',
				sprintf(
					'<div class="promo-slider__slide-content-item promo-slider__slide-content-item--free" style="width: %2$d%1$s; height: %3$d%1$s; top: %4$d%1$s; left: %5$d%1$s;"><img class="image image--responsive animated" src="%6$s" data-anim-name="%7$s" data-anim-delay="%8$fs" data-anim-duration="%9$fs" /></div>',
					esc_attr( $free_image[ 'unit' ] ?? '%' ),
					esc_attr( $free_image[ 'width' ] ?? 50 ),
					esc_attr( $free_image[ 'height' ] ?? 50 ),
					esc_attr( $free_image[ 'top' ] ?? 0 ),
					esc_attr( $free_image[ 'left' ] ?? 0 ),
					esc_url( wp_get_attachment_image_url( $attach_id, 'full' ) ),
					esc_attr( $free_image[ 'animation' ] ?? 'fadeIn' ),
					esc_attr( $free_image[ 'delay' ] ?? 0 ),
					esc_attr( $free_image[ 'duration' ] ?? 0 )
				),
				$post,
				$screen,
				$opts,
				$query,
				$lang_domain,
				$free_image,
				$attach_id
			);
		}
	}
}
