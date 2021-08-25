<?php
/**
 * HTML meta field.
 *
 * HTML разметка мета поля.
 *
 * @param Array $params - параметры мета поля.
 * @param String $key   - имя мета поля.
 * @param String $value - значение мета поля.
 *
 * @return void
 *
 * @since 0.0.1
 * @author Ravil
 */
?>

<div class="form-field briz-meta-color-wrap">
	<span class="briz-meta-title">
		<?php _e( $params[ 'title' ] ); ?>
	</span>

	<input
		name="<?php echo esc_attr( $key ); ?>"
		type="color"
		value="<?php echo esc_attr( $value ); ?>"
	/>

	<p class="description">
		<?php _e( $params[ 'desc' ] ); ?>
	</p>
</div>
