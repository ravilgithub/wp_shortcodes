<tr class="form-field briz-meta-select-wrap">
	<th scope="row">
		<span class="briz-meta-title">
			<?php _e( $params[ 'title' ] ); ?>
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
