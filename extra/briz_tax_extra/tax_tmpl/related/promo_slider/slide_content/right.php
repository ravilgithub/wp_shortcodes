<?php
/**
 * Slide layout.
 *
 * HTML разметка слайда.
 *
 * @param String $post_content - контент слайда.
 * @param String $content_image_src - путь к изображению.
 * @param String $img_title - заголовок изображения.
 * @param String $img_alt - альтернативный текст для изображения.
 * @param String $content_image_animation - тип анимации для изображения.
 * @param String $content_image_delay - задержка анимации для изображения.
 * @param String $content_image_duration - продолжительность анимации для изображения.
 *
 * @return void
 *
 * @since 0.0.1
 * @author Ravil
 */

    defined( 'ABSPATH' ) || exit;
?>

<div
    class="
        promo-slider__slide-content
        promo-slider__slide-content--center
        promo-slider__slide-content--screen-sm-half
    "
    style="width: 58.33333333%"
>
    <img
        class="
            promo-slider__slide-content-item
            image
            image--responsive
            animated
        "
        src="<?php echo $content_image_src; ?>"
        title="<?php echo $img_title; ?>"
        alt="<?php echo $img_alt; ?>"
        data-anim-name="<?php echo esc_attr( $content_image_animation ); ?>"
        data-anim-delay="<?php echo esc_attr( $content_image_delay ); ?>"
        data-anim-duration="<?php echo esc_attr( $content_image_duration ); ?>"
    />
</div>

<div
    class="
        promo-slider__slide-content
        promo-slider__slide-content--left
        promo-slider__slide-content--screen-sm-half
    "
    style="width: 41.66666667%"
>

    <?php echo $post_content; ?>

</div>
