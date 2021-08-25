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

<div class="form-field briz-meta-url-wrap">
	<span class="briz-meta-title">
		<?php _e( $params[ 'title' ] ); ?>
	</span>

	<input
		type="url"
		name="<?php echo $key; ?>"
		value="<?php echo $value; ?>"
		pattern="<?php echo $params[ 'pattern' ]; ?>"
		required="<?php echo $params[ 'required' ] ? 'required' : ''; ?>"
	/>

	<p class="description">
		<?php _e( $params[ 'desc'] ); ?>
	</p>
</div>
