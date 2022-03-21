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
	class="form-field briz-meta-textarea-wrap briz-meta-field"
	data-briz-meta-field-default="<?php echo esc_attr( $params[ 'value' ] ); ?>"
	data-briz-meta-field-current="<?php echo esc_attr( $value ); ?>"
	data-briz-meta-field-empty="<?php echo esc_attr( $empty ); ?>"
	data-briz-meta-field-type="textarea"
>
	<th scope="row">
		<span class="briz-meta-title">
			<?php
				_e( $params[ 'title' ], $this->lang_domain );

				if ( $saved ) {
					$hideClass = 'briz-hidden';
				}
			?>
			<em class="briz-unsaved <?php echo esc_attr( $hideClass ); ?>">*</em>
		</span>
	</th>

	<td>
		<div class="briz-meta-field-inner">
			<textarea
				class="briz-meta-field-item"
				name="<?php echo esc_attr( $key ); ?>"
				rows="5"
				cols="50"
				class="large-text"
			><?php _e( $value, $this->lang_domain ); ?></textarea>

			<button type="button" class="button briz-reset-default"><?php _e( 'Reset', $this->lang_domain ); ?></button>
		</div>

		<p class="description">
			<?php _e( $params[ 'desc'], $this->lang_domain ); ?>
		</p>
	</td>
</tr>
