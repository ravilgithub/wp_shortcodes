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

	$defaults = [
		'title'    => 'Insert a media',
		'library'  => [ 'type' => 'image' ],
		'multiple' => false,
		'button'   => [ 'text' => 'Insert' ]
	];

	$opts = wp_parse_args( $params[ 'options' ], $defaults );
	extract( $opts );

	$stage = 'addidable';
	$add_action_txt = __( 'Add медиафайлы' );
	$edit_action_txt = __( 'Edit медиафайлы' );
	$btn_action_txt = $add_action_txt;
	$delBtnClass = '';

	if ( $value ) {
		$stage = 'editable';
		$btn_action_txt = $edit_action_txt;
		$delBtnClass = 'briz-del-media-btn-active';
	}
?>

<tr class="form-field briz-meta-media-btn-wrap">
	<th scope="row">
		<span class="briz-meta-title">
			<?php echo $params[ 'title' ]; ?>
			<?php if ( ! $saved ) : ?>
				<em class="briz-unsaved">*</em>
			<?php endif; ?>
		</span>
	</th>

	<td>
		<button
			type="button"
			class="button briz-add-media-btn"
			data-title="<?php echo esc_attr( $title ); ?>"
			data-library-type="<?php echo esc_attr( $library[ 'type' ] ); ?>"
			data-multiple="<?php echo esc_attr( $multiple ); ?>"
			data-button-text="<?php echo esc_attr( $button[ 'text' ] ); ?>"
			data-action-text="<?php echo esc_attr( $edit_action_txt ); ?>"
			data-stage="<?php echo esc_attr( $stage ); ?>"
		>
			<?php echo $btn_action_txt; ?>
		</button>

		<button
			type="button"
			class="button briz-del-media-btn <?php echo esc_attr( $delBtnClass ); ?>"
			data-action-text="<?php echo esc_attr( $add_action_txt ); ?>"
		>
			<?php echo __( 'Удалить медиафайлы' ); ?>
		</button>

		<p class="description">
			<?php _e( $params[ 'desc'] ); ?>
		</p>

		<figure>
			<span class="briz-media-place">
<?php
					if ( $value ) :
						$v = json_decode( $value );
						if ( ! empty( $v ) ) :
							foreach ( $v as $media_id ) :
?>
								<span class="briz-media-place-item">
<?php
									$details = wp_prepare_attachment_for_js( $media_id );
									$src = $details[ 'url' ];

									if ( isset( $details[ 'sizes' ][ 'thumbnail' ] ) ) {
										$src = $details[ 'sizes' ][ 'thumbnail' ][ 'url' ];
									}

									// Image
									if ( 'image' == $library[ 'type' ] ) :
?>
										<img
											src="<?php echo esc_attr( $src ); ?>"
											alt="<?php echo esc_attr( $details[ 'alt' ] ); ?>"
										/>
<?php
									// Audio
									elseif ( 'audio' == $library[ 'type' ] ) :
?>
										<audio src="<?php echo esc_attr( $src ); ?>" controls></audio>
<?php
									// Video
									elseif ( 'video' == $library[ 'type' ] ) :
?>
										<video src="<?php echo esc_attr( $src ); ?>" controls></video>
<?php
									endif;

									if ( $caption = $details[ 'caption' ] ) :
?>
										<figcaption>
											<?php echo $caption; ?>
										</figcaption>
<?php
									endif;
?>
								</span> <!-- .briz-media-place-item -->
<?php
							endforeach;
						endif;
					endif;
?>
			</span> <!-- .briz-media-place -->
		</figure>

		<input
			type="hidden"
			name="<?php echo esc_attr( $key ); ?>"
			value="<?php echo esc_attr( $value ); ?>"
		/>
	</td>
</tr>
