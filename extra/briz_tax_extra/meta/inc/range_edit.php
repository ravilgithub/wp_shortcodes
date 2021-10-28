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

<tr class="form-field briz-meta-range-wrap">
	<th scope="row">
		<span class="briz-meta-title">
			<?php _e( $params[ 'title' ] ); ?>
			<?php if ( ! $saved ) : ?>
				<em class="briz-unsaved">*</em>
			<?php endif; ?>
		</span>
	</th>

	<td>
		<p>
			<?php _e( 'Current value' ); ?>:
			<span class="briz-meta-range-current-value">
				<?php echo $value; ?>
			</span>
		</p>

		<input
			name="<?php echo $key; ?>"
			type="range"
			value="<?php echo $value; ?>"
			step="<?php echo $params[ 'options' ][ 'step' ]; ?>"
			min="<?php echo $params[ 'options' ][ 'min' ]; ?>"
			max="<?php echo $params[ 'options' ][ 'max' ]; ?>"
		/>

		<p class="description">
			<?php _e( $params[ 'desc'] ); ?>
		</p>
	</td>
</tr>
