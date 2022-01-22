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
	$add_action_txt = __( 'Add' );
	$edit_action_txt = __( 'Edit' );
	$btn_action_txt = $add_action_txt;
	$delBtnClass = '';

	if ( $value && '[]' !== $value ) {
		$stage = 'editable';
		$btn_action_txt = $edit_action_txt;
		$delBtnClass = 'briz-active';
	}
?>

<div class="form-field briz-meta-media-wrap">
	<span class="briz-meta-media-title">
		<?php _e( $params[ 'title' ] ); ?>
	</span>

	<div class="briz-meta-media-box">
		<div class="briz-meta-media-controls">
			<button
				type="button"
				class="button briz-meta-media-add-btn"
				data-title="<?php echo esc_attr( $title ); ?>"
				data-library-type="<?php echo esc_attr( json_encode( $library[ 'type' ] ) ); ?>"
				data-multiple="<?php echo esc_attr( $multiple ); ?>"
				data-button-text="<?php echo esc_attr( $button[ 'text' ] ); ?>"
				data-action-text="<?php echo esc_attr( $edit_action_txt ); ?>"
				data-stage="<?php echo esc_attr( $stage ); ?>"
			>
				<?php echo $btn_action_txt; ?>
			</button>

			<button
				type="button"
				class="button briz-meta-media-del-all-btn <?php echo esc_attr( $delBtnClass ); ?>"
				data-action-text="<?php echo esc_attr( $add_action_txt ); ?>"
			>
				<?php echo __( 'Delete all' ); ?>
			</button>
		</div> <!-- .briz-meta-media-controls -->

		<p class="description">
			<?php _e( $params[ 'desc'] ); ?>
		</p>

		<div class="briz-meta-media-place">
<?php
			if ( $value && '[]' !== $value ) :
				$v = json_decode( $value );
				if ( ! empty( $v ) ) :
					foreach ( $v as $media_id ) :
						$details = wp_prepare_attachment_for_js( $media_id );
						$src = $details[ 'url' ];
						$type = $details[ 'type' ];

						if ( isset( $details[ 'sizes' ][ 'thumbnail' ] ) ) {
							$src = $details[ 'sizes' ][ 'thumbnail' ][ 'url' ];
						}
?>
						<div
							class="briz-meta-media-item-wrap <?php echo esc_attr( $type ); ?>"
							data-media-id="<?php echo esc_attr( $media_id ); ?>"
						>
							<figure
								title="<?php esc_attr_e( $details[ 'caption' ] ); ?>"
								class="briz-meta-media-item"
							>
								<i class="briz-meta-media-del-item-btn">×</i>
<?php
								// Image
								if ( 'image' == $type ) :
?>
									<img
										src="<?php echo esc_attr( $src ); ?>"
										alt="<?php echo esc_attr( $details[ 'alt' ] ); ?>"
									/>
<?php
								endif;

								// Audio
								if ( 'audio' == $type ) :
?>
									<audio src="<?php echo esc_attr( $src ); ?>" controls></audio>
<?php
								endif;

								// Video
								if ( 'video' == $type ) :
?>
									<video src="<?php echo esc_attr( $src ); ?>" controls></video>
<?php
								endif;

								// if ( $caption = $details[ 'caption' ] ) :
?>
									<!-- <figcaption> -->
										<?php // echo $caption; ?>
									<!-- </figcaption> -->
<?php
								// endif;
?>
							</figure> <!-- .briz-meta-media-item -->
						</div> <!-- .briz-meta-media-item-wrap -->
<?php
					endforeach;
				endif;
			endif;
?>
		</div> <!-- .briz-meta-media-place -->
	</div> <!-- .briz-meta-media-box -->

	<input
		type="hidden"
		class="briz-meta-media-collection"
		name="<?php echo esc_attr( $key ); ?>"
		value="<?php echo esc_attr( $value ); ?>"
	/>
</div>
