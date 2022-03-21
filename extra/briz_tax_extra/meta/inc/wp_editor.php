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

	$args = array_merge(
		[
			'textarea_name'    => $key, //нужно указывать!
			'editor_class'     => 'briz-meta-field-item',
			// изменяемое
			'wpautop'          => 1,
			'textarea_rows'    => 5,
			'tabindex'         => null,
			'editor_css'       => '',
			'teeny'            => 0,
			'dfw'              => 0,
			'tinymce'          => 1,
			'quicktags'        => 1,
			'media_buttons'    => false,
			'drag_drop_upload' => false
		],
		$params[ 'options' ]
	);

	$empty = array_key_exists( 'empty', $params ) ? $params[ 'empty' ] : false;
	$hideClass = '';
?>

<div
	class="form-field briz-meta-wp-editor-wrap briz-meta-field"
	data-briz-meta-field-default="<?php echo esc_attr( $params[ 'value' ] ); ?>"
	data-briz-meta-field-current="<?php echo esc_attr( $value ); ?>"
	data-briz-meta-field-empty="<?php echo esc_attr( $empty ); ?>"
	data-briz-meta-field-type="wp_editor"
>
	<span class="briz-meta-title">
		<?php
			_e( $params[ 'title' ], $this->lang_domain );

			if ( $saved ) {
				$hideClass = 'briz-hidden';
			}
		?>
		<em class="briz-unsaved <?php echo esc_attr( $hideClass ); ?>">*</em>
	</span>

	<div class="briz-meta-field-inner">
		<?php
			echo $value;
			wp_editor( $value, $key, $args );
		?>
		<button type="button" class="button briz-reset-default"><?php _e( 'Reset', $this->lang_domain ); ?></button>
	</div>

	<p class="description">
		<?php _e( $params[ 'desc'], $this->lang_domain ); ?>
	</p>
</div>
