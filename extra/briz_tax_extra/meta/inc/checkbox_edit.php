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

<tr class="form-field briz-meta-checkbox-wrap">
	<th scope="row">
		<span class="briz-meta-title">
			<?php _e( $params[ 'title' ] ); ?>
			<?php if ( ! $saved ) : ?>
				<em class="briz-unsaved">*</em>
			<?php endif; ?>
		</span>
	</th>

	<td>
		<!--
			Если checkbox'ы не выбраны то в $_POST будет пустое поле,
			что позволит удалить его из БД.
		-->
		<input type="hidden" name="<?php echo $key; ?>" value="">

		<?php foreach ( $params[ 'options' ] as $k => $v ) : ?>
			<label>
				<input
					name="<?php echo $key . '[]'; ?>"
					type="checkbox"
					value="<?php echo $k; ?>"
					<?php checked( true, in_array( $k, (array) $value ) ); ?>
				/>
				<?php echo $v; ?>
			</label>
		<?php endforeach; ?>

		<p class="description">
			<?php _e( $params[ 'desc'] ); ?>
		</p>
	</td>
</tr>
