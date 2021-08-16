<?php
	$args = array_merge(
		[
			'textarea_name'    => $key, //нужно указывать!
			'editor_class'     => 'editor-class',
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
?>
<tr class="form-field briz-meta-wp-editor-wrap">
	<th scope="row">
		<span class="briz-meta-title">
			<?php _e( $params[ 'title' ] ); ?>
		</span>
	</th>

	<td>

		<?php
			echo $value;
			wp_editor( $value, $key, $args );
		?>

		<p class="description">
			<?php _e( $params[ 'desc'] ); ?>
		</p>
	</td>
</tr>
