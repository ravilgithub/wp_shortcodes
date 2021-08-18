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

<div class="form-field briz-meta-radio-wrap">
	<span class="briz-meta-title">
		<?php _e( $params[ 'title' ] ); ?>
	</span>

	<?php foreach ( $params[ 'options' ] as $k => $v ) : ?>
		<label>
			<input
				type="radio"
				name="<?php echo $key; ?>"
				value="<?php echo $k; ?>"
				<?php checked( $k, $value ); ?>
			/>

			<?php echo $v; ?>
		</label>
	<?php endforeach; ?>

	<p class="description">
		<?php _e( $params[ 'desc'] ); ?>
	</p>
</div>
