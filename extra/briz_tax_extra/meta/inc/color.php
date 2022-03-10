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

	$empty = array_key_exists( 'empty', $params ) ? $params[ 'empty' ] : false;
	$hideClass = '';
?>

<div
	class="form-field briz-meta-color-wrap briz-meta-field"
	data-briz-meta-field-default="<?php echo esc_attr( $params[ 'value' ] ); ?>"
	data-briz-meta-field-current="<?php echo esc_attr( $value ); ?>"
	data-briz-meta-field-empty="<?php echo esc_attr( $empty ); ?>"
	data-briz-meta-field-type="color"
>
	<span class="briz-meta-title">
		<?php
			_e( $params[ 'title' ] );

			if ( $saved ) {
				$hideClass = 'briz-hidden';
			}
		?>
		<em class="briz-unsaved <?php echo esc_attr( $hideClass ); ?>">*</em>
	</span>

	<div class="briz-meta-field-inner">
		<input
			class="briz-meta-field-item"
			name="<?php echo esc_attr( $key ); ?>"
			type="color"
			value="<?php echo esc_attr( $value ); ?>"
		/>

		<button type="button" class="button briz-reset-default"><?php _e( 'Reset' ); ?></button>
	</div>

	<p class="description">
		<?php _e( $params[ 'desc' ] ); ?>
	</p>
</div>
