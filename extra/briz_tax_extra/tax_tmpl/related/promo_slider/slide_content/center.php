<?php
/**
 * Slide layout.
 *
 * HTML разметка слайда.
 *
 * @param String $post_content - контент слайда.
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
    "
    style="width: 50%"
>

    <?php echo $post_content; ?>

</div>
