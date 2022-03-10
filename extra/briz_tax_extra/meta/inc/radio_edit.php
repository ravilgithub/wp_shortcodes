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

<tr
	class="form-field briz-meta-radio-wrap briz-meta-field"
	data-briz-meta-field-default="<?php echo esc_attr( $params[ 'value' ] ); ?>"
	data-briz-meta-field-current="<?php echo esc_attr( $value ); ?>"
	data-briz-meta-field-empty="<?php echo esc_attr( $empty ); ?>"
	data-briz-meta-field-type="radio"
>
	<th scope="row">
		<span class="briz-meta-title">
			<?php
				_e( $params[ 'title' ] );

				if ( $saved ) {
					$hideClass = 'briz-hidden';
				}
			?>
			<em class="briz-unsaved <?php echo esc_attr( $hideClass ); ?>">*</em>
		</span>
	</th>

	<td>
		<div class="briz-meta-field-inner">
			<?php foreach ( $params[ 'options' ] as $k => $v ) : ?>
				<label>
					<input
						class="briz-meta-field-item"
						type="radio"
						name="<?php echo $key; ?>"
						value="<?php echo $k; ?>"
						<?php checked( $k, $value ); ?>
					/>

					<?php echo $v; ?>
				</label>
			<?php endforeach; ?>

			<button type="button" class="button briz-reset-default"><?php _e( 'Reset' ); ?></button>
		</div>

		<p class="description">
			<?php _e( $params[ 'desc'] ); ?>
		</p>
	</td>
</tr>
