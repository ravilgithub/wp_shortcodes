<div class="form-field briz-meta-text-wrap">
	<span class="briz-meta-title">
		<?php _e( $params[ 'title' ] ); ?>
	</span>

	<input
		name="<?php echo esc_attr( $key ); ?>"
		type="text"
		value="<?php echo esc_attr( $value ); ?>"
		size="40"
	/>

	<p class="description">
		<?php _e( $params[ 'desc' ] ); ?>
	</p>
</div>
