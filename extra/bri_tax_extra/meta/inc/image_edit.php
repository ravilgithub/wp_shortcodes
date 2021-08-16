<?php
	$img_id = ( int ) $value;
	$img_url = $params[ 'value' ];
	$btn_class = 'hidden';

	if ( $img_id ) {
		$img_url = wp_get_attachment_image_url( $img_id, [ 60, 60 ] );
		$btn_class = '';
	}
?>

<tr class="form-field briz-meta-img-wrap">
	<th scope="row">
		<span class="briz-meta-title">
			<?php _e( $params[ 'title' ] ); ?>
		</span>
	</th>

	<td>
		<figure>
			<a href="#">
				<img
					src="<?php echo esc_attr( $img_url ); ?>"
					data-default="<?php echo esc_attr( $params[ 'value' ] ); ?>"
					alt="Alt"
				/>
			</a>

			<button type="button" class="button <?php echo esc_attr( $btn_class ); ?>">
				<?php _e( 'Remove' ); ?>
			</button>
		</figure>

		<p class="description">
			<?php _e( $params[ 'desc'] ); ?>
		</p>

		<input
			type="hidden"
			name="<?php echo esc_attr( $key ); ?>"
			value="<?php echo esc_attr( $img_id ); ?>"
		/>
	</td>
</tr>
