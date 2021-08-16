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
