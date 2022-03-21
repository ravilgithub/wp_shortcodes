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

<div class="form-field briz-meta-img-wrap">
	<span class="briz-meta-title">
		<?php _e( $params[ 'title' ], $this->lang_domain ); ?>
	</span>

	<figure>
		<a href="#">
			<img
				src="<?php echo esc_attr( $value ); ?>"
				data-default="<?php echo esc_attr_e( $params[ 'value' ], $this->lang_domain ); ?>"
				alt="Alt"
			/>
		</a>

		<button type="button" class="button hidden">
			<?php _e( 'Remove', $this->lang_domain ); ?>
		</button>
	</figure>

	<p class="description">
		<?php _e( $params[ 'desc'], $this->lang_domain ); ?>
	</p>

	<input
		type="hidden"
		name="<?php echo esc_attr( $key ); ?>"
		value=""
	/>
</div>
