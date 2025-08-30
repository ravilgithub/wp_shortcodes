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
