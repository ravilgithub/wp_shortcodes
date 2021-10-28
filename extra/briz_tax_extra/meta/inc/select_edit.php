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

<tr class="form-field briz-meta-select-wrap">
	<th scope="row">
		<span class="briz-meta-title">
			<?php _e( $params[ 'title' ] ); ?>
			<?php if ( ! $saved ) : ?>
				<em class="briz-unsaved">*</em>
			<?php endif; ?>
		</span>
	</th>

	<td>
		<select name="<?php echo esc_attr( $key ); ?>">
			<?php foreach ( $params[ 'options' ] as $k => $v ) : ?>
				<option
					value="<?php echo $k; ?>"
					<?php selected( $value, $k, true ); ?>
				><?php echo $v; ?></option>
			<?php endforeach; ?>
		</select>

		<p class="description">
			<?php _e( $params[ 'desc'] ); ?>
		</p>
	</td>
</tr>
