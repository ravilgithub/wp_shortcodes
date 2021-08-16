<tr class="form-field briz-meta-textarea-wrap">
	<th scope="row">
		<span class="briz-meta-title">
			<?php _e( $params[ 'title' ] ); ?>
		</span>
	</th>

	<td>
		<textarea
			name="<?php echo esc_attr( $key ); ?>"
			rows="5"
			cols="50"
			class="large-text"
		><?php _e( $value ); ?></textarea>

		<p class="description">
			<?php _e( $params[ 'desc'] ); ?>
		</p>
	</td>
</tr>
