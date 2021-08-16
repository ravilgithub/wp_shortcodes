<div class="form-field briz-meta-number-wrap">
	<span class="briz-meta-title">
		<?php _e( $params[ 'title' ] ); ?>
	</span>

	<input
		name="<?php echo esc_attr( $key ); ?>"
		type="number"
		value="<?php echo esc_attr( $value ); ?>"
		step="<?php echo esc_attr( $params[ 'options' ][ 'step' ] ); ?>"
		min="<?php echo esc_attr( $params[ 'options' ][ 'min' ] ); ?>"
		max="<?php echo esc_attr( $params[ 'options' ][ 'max' ] ); ?>"
	/>

	<p class="description">
		<?php _e( $params[ 'desc' ] ); ?>
	</p>
</div>
