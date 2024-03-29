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

	$img_id = ( int ) $value;
	$img_url = $params[ 'value' ];
	$btn_class = 'hidden';

	if ( $img_id ) {
		$img_url = wp_get_attachment_image_url( $img_id, [ 60, 60 ] );
		$btn_class = '';
	}

	$hideClass = '';
?>

<tr class="form-field briz-meta-img-wrap">
	<th scope="row">
		<span class="briz-meta-title">
			<?php
				_e( $params[ 'title' ], $this->lang_domain );

				if ( $saved ) {
					$hideClass = 'briz-hidden';
				}
			?>
			<em class="briz-unsaved <?php echo esc_attr( $hideClass ); ?>">*</em>
		</span>
	</th>

	<td>
		<figure>
			<a href="#">
				<img
					src="<?php echo esc_attr( $img_url ); ?>"
					data-default="<?php echo esc_attr_e( $params[ 'value' ], $this->lang_domain ); ?>"
					alt="Alt"
				/>
			</a>

			<button type="button" class="button <?php echo esc_attr( $btn_class ); ?>">
				<?php _e( 'Remove', $this->lang_domain ); ?>
			</button>
		</figure>

		<p class="description">
			<?php _e( $params[ 'desc'], $this->lang_domain ); ?>
		</p>

		<input
			type="hidden"
			name="<?php echo esc_attr( $key ); ?>"
			value="<?php echo esc_attr( $img_id ); ?>"
		/>
	</td>
</tr>
