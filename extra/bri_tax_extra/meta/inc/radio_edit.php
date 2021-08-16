<tr class="form-field briz-meta-radio-wrap">
	<th scope="row">
		<span class="briz-meta-title">
			<?php _e( $params[ 'title' ] ); ?>
		</span>
	</th>

	<td>
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
	</td>
</tr>
