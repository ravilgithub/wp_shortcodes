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

	$default = json_encode( $params[ 'value' ] );
	$current = json_encode( $value );
	$empty = array_key_exists( 'empty', $params ) ? $params[ 'empty' ] : false;
	$hideClass = '';
?>

<div
	class="form-field briz-meta-checkbox-wrap briz-meta-field"
	data-briz-meta-field-default="<?php echo esc_attr( $default ); ?>"
	data-briz-meta-field-current="<?php echo esc_attr( $current ); ?>"
	data-briz-meta-field-empty="<?php echo esc_attr( $empty ); ?>"
	data-briz-meta-field-type="checkbox"
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

	<!--
		Если checkbox'ы не выбраны то в $_POST будет пустое поле,
		что позволит удалить его из БД.
	-->
	<input type="hidden" name="<?php echo $key; ?>" value="">

	<div class="briz-meta-field-inner">
		<?php foreach ( $params[ 'options' ] as $k => $v ) : ?>
			<label>
				<input
					class="briz-meta-field-item"
					name="<?php echo $key . '[]'; ?>"
					type="checkbox"
					value="<?php echo $k; ?>"
					<?php checked( true, in_array( $k, (array) $value ) ); ?>
				/>
				<?php echo $v; ?>
			</label>
		<?php endforeach; ?>

		<button type="button" class="button briz-reset-default"><?php _e( 'Reset' ); ?></button>
	</div>

	<p class="description">
		<?php _e( $params[ 'desc'] ); ?>
	</p>
</div>
