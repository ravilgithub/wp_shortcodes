<tr class="form-field briz-meta-color-wrap">
	<th scope="row">
		<span class="briz-meta-title"><?php _e( $params[ 'title' ] ); ?></span>
	</th>

	<td>
		<input
			name="<?php echo esc_attr( $key ); ?>"
			type="color"
			value="<?php echo esc_attr( $value ); ?>"
		/>

		<p class="description">
			<?php _e( $params[ 'desc'] ); ?>
		</p>
	</td>
</tr>
