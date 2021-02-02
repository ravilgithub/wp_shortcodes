<?php

namespace Bri_Shortcodes;

class Meta_boxes {
	public $taxs;
	public $id = 'briz';

	public $opts = [];

	public function __construct( $taxs ) {
		// Helper::debug( __CLASS__, '200px' );
		$this->taxs = $taxs;

		// Helper::debug( plugin_dir_path( __FILE__ ) . 'meta/meta_opts.php', '200px' );

		require_once( plugin_dir_path( __FILE__ ) . 'meta/meta_opts.php' );
		$this->opts = apply_filters( 'briz_meta_opts', $opts );
		// Helper::debug( $this->opts );

		add_action( 'admin_enqueue_scripts', [ $this, 'add_assets' ] );
		add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ], 10, 2 );
		add_action( 'save_post', [ $this, 'meta_box_save' ], 1, 2 );
	}

	/**
	 * Registering Styles and Scripts of metaboxes.
	 * 
	 * Регистрация стилей и скриптов метабоксов.
	 * 
	 * @see Helper::register_assets()
	 * @link ~/common/helpers.php
	 * 
	 * @return void.
	 * 
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function add_assets() {
		$assets = [
			'css' => [
				/************ TMPL CSS ************/
				'id'   => 'metabox-tmpl-css',
				'src'  => PLUGIN_URL . 'extra/bri_tax_extra/assets/css/metabox.min.css',
				'deps' => [],
				'ver'  => '1.0.0'
			],
			'js' => [
				/************ TMPL SCRIPTS ************/
				'id'   => 'metabox-tmpl-js',
				'src'  => PLUGIN_URL . 'extra/bri_tax_extra/assets/js/metabox.js',
				'deps' => [ 'jquery' ],
				'ver'  => '1.0.0',
				'in_footer' => true
			]
		];

		$assets = apply_filters( "briz_metabox_assets", $assets );

		// Helper::debug( $assets );

		foreach ( $assets as $type => $data ) {
			extract( $data );

			if ( 'css' == $type ) {
				if ( ! wp_style_is( $id, 'enqueued' ) )
					wp_enqueue_style( $id, $src, $deps, $ver );
			} else {
				if ( ! wp_script_is( $id, 'enqueued' ) )
					wp_enqueue_script( $id, $src, $deps, $ver, $in_footer );
			}
		}
	}

	public function get_terms_info( $post ) {
		$taxs = get_object_taxonomies( $post );
		// Helper::debug( $taxs, '200px' );

		$term_info = [];

		foreach ( $taxs as $tax ) {
			if ( in_array( $tax, $this->taxs ) ) {
				$term_info[ 'tmpl' ] = [];
				$term_info[ 'taxonomy' ] = $tax;
				$terms = get_the_terms( $post->ID, $tax );

				if ( ! empty( $terms ) ) {
					foreach ( $terms as $k => $term ) {
						$term_id = $term->term_id;
						// $term_info[ $k ][ 'taxonomy' ] = $tax;
						// $term_info[ $k ][ 'term_id' ] = $term_id;

						do {
							$tmpl_path = get_term_meta( $term_id, 'tmpl', $tax );

							if ( -1 != $tmpl_path ) {
								$tmpl_info = pathinfo( $tmpl_path );
								$tmpl_name = $tmpl_info[ 'filename' ];

								if ( ! in_array( $tmpl_name, $term_info[ 'tmpl' ] ) ) {
									$term_info[ 'tmpl' ][] = $tmpl_name;
								}
								// $term_info[ $k ][ 'tmpl' ][ $term_id ] = $tmpl_info[ 'filename' ];
							}

							$curent_term = get_term_by( 'id', $term_id, $tax );
							$term_id = $curent_term->parent;
						} while ( $term_id );
					}
				}

				// Helper::debug( $terms, '200px' );
				// Helper::debug( $tax, '200px' );
				// Helper::debug( $post_terms, '200px' );
			}
		}

		// Helper::debug( $term_info, '200px' );
		return $term_info;
	}

	public function add_meta_box( $post_type, $post ) {
		// Helper::debug( __METHOD__, '200px' );
		// Helper::debug( $post_type, '200px' );
		// Helper::debug( $post, '200px' );

		$screens = [ 'post', 'product' ];
		$callback = [ $this, 'meta_box' ];
		$terms_info = $this->get_terms_info( $post );

		/**
		 * Добавляем метаблок только указанным типам записи.
		 */
		if ( ! in_array( $post_type, $screens ) ) {
			return;
		}

		$n = 0;
		foreach ( $terms_info[ 'tmpl' ] as $tmpl ) {
			$n++;
			$title = __( "Options for term template: " ) . ucfirst( $tmpl );

			$tax = $terms_info[ 'taxonomy' ];
			$callback_args[ 'taxonomy' ] = $tax;
			$callback_args[ 'tmpl' ] = $tmpl;
			$callback_args[ 'fields' ] = $this->opts[ $tax ][ $tmpl ][ 'fields' ];

			// Helper::debug( $tmpl, '200px' );

			add_meta_box( "briz_meta_box_{$n}", $title, $callback, $screens, 'advanced', 'default', $callback_args );
		}
	}

	public function meta_box( $post, $meta ) {
		// Helper::debug( __METHOD__, '200px' );
		// Helper::debug( $post, '200px' );
		// Helper::debug( $meta, '200px' );

		$tax = $meta[ 'args' ][ 'taxonomy' ];
		$tmpl = $meta[ 'args' ][ 'tmpl' ];
?>
		<div id="briz_meta_box">
			<table width="100%">
				<thead>
				<tr>
					<th width>Имя</th>
					<th width>Значение</th>
				</tr>
				</thead>
				<tbody>

					<?php
						foreach ( $meta[ 'args' ][ 'fields' ] as $field_name => $field_params ) {
							$field_key = '_' . $tax . '_' . $tmpl . '_' . $field_name;
							$field_value = get_post_meta( $post->ID, $field_key, true );
							$field_value = $field_value ? $field_value : $field_params[ 'value' ];

							$field_key = $this->id . "[$field_key]";

							switch ( $field_params[ 'type' ] ) {
								case 'textarea': $this->textarea_field( $field_key, $field_value, $field_params );
									break;
								case 'color': $this->color_field( $field_key, $field_value, $field_params );
									break;
								case 'number': $this->number_field( $field_key, $field_value, $field_params );
									break;
								case 'select': $this->select( $field_key, $field_value, $field_params );
									break;
								case 'checkbox': $this->checkbox( $field_key, $field_value, $field_params );
									break;
								case 'range': $this->range_field( $field_key, $field_value, $field_params );
									break;
								case 'radio': $this->radio( $field_key, $field_value, $field_params );
									break;
								case 'url': $this->url_field( $field_key, $field_value, $field_params );
									break;
								case 'wp_editor': $this->wp_editor( $field_key, $field_value, $field_params );
									break;
								case 'media_button': $this->media_button( $field_key, $field_value, $field_params );
									break;
								default: $this->text_field( $field_key, $field_value, $field_params );
									break;
							}
						}
					?>

				</tbody>
			</table>
		</div>

		<style>
			#briz_meta_box table {
				width: 100%;
			}
			#briz_meta_box td {
				padding-top: 10px;
			}
			#briz_meta_box td:first-child {
				width: 25%;
			}
			#briz_meta_box td:last-child {
				width: 75%;
			}
			#briz_meta_box th,
			#briz_meta_box td {
				vertical-align: top;
				text-align: left;
			}
			#briz_meta_box label,
			#briz_meta_box small,
			#briz_meta_box textarea,
			#briz_meta_box input[type=text] {
				display: block;
				width: 100%;
			}
			#briz_meta_box input[type=url]:-moz-ui-invalid {
				box-shadow: 0px 0px 1.5px 1px #5cff00;
			}
		</style>
<?php
	}

	public function text_field( $key, $value, $params ) {
?>
		<tr>
			<td>
				<label for="<?php echo $key; ?>">
					<?php echo $params[ 'title' ]; ?>
				</label>
			</td>
			<td>
				<?php echo $value; ?>
				<input type="text" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo $value; ?>"/>
				<small>
					<em><?php echo $params[ 'desc' ]; ?></em>
				</small>
			</td>
		</tr>
<?php
	}

	public function textarea_field( $key, $value, $params ) {
?>
		<tr>
			<td>
				<label for="<?php echo $key; ?>">
					<?php echo $params[ 'title' ]; ?>
				</label>
			</td>
			<td>
				<textarea id="<?php echo $key; ?>" name="<?php echo $key; ?>"><?php echo $value; ?></textarea>
				<small>
					<em><?php echo $params[ 'desc' ]; ?></em>
				</small>
			</td>
		</tr>
<?php
	}

	public function color_field( $key, $value, $params ) {
?>
		<tr>
			<td>
				<label for="<?php echo $key; ?>">
					<?php echo $params[ 'title' ]; ?>
				</label>
			</td>
			<td>
				<?php echo $value; ?>
				<input type="color" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo $value; ?>"/>
				<small>
					<em><?php echo $params[ 'desc' ]; ?></em>
				</small>
			</td>
		</tr>
<?php
	}

	public function number_field( $key, $value, $params ) {
		extract( $params[ 'options' ] );
?>
		<tr>
			<td>
				<label for="<?php echo $key; ?>">
					<?php echo $params[ 'title' ]; ?>
				</label>
			</td>
			<td>
				<?php echo $value; ?>
				<input
					type="number"
					id="<?php echo $key; ?>"
					name="<?php echo $key; ?>"
					value="<?php echo $value; ?>"
					step="<?php echo $step; ?>"
					min="<?php echo $min; ?>"
					max="<?php echo $max; ?>"
				/>
				<small>
					<em><?php echo $params[ 'desc' ]; ?></em>
				</small>
			</td>
		</tr>
<?php
	}

	public function select( $key, $value, $params ) {
?>
		<tr>
			<td>
				<label for="<?php echo $key; ?>">
					<?php echo $params[ 'title' ]; ?>
				</label>
			</td>
			<td>
				<?php echo $value; ?>
				<select name="<?php echo $key; ?>" id="<?php echo $key; ?>">
					<?php foreach ( $params[ 'options' ] as $k => $v ) : ?>	
						<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
					<?php endforeach; ?>
				</select>
				<small>
					<em><?php echo $params[ 'desc' ]; ?></em>
				</small>
			</td>
		</tr>
<?php
	}

	public function checkbox( $key, $value, $params ) {
?>
		<tr>
			<td>
				<label>
					<?php echo $params[ 'title' ]; ?>
				</label>
			</td>
			<td>

				<!-- Если checkbox'ы не выбраны то в $_POST будет пустое поле, что позволит удалить его из БД. -->
				<input type="hidden" name="<?php echo $key; ?>" value="">

				<?php Helper::debug( (array) $value ); ?>

				<?php foreach ( $params[ 'options' ] as $k => $v ) : ?>
					<label for="<?php echo $k; ?>">
						<input
							type="checkbox"
							id="<?php echo $k; ?>"
							name="<?php echo $key . '[]'; ?>"
							value="<?php echo $v; ?>"
							<?php checked( true, in_array( $v, (array) $value ) ); ?>
						/>
						<?php echo $v; ?>
					</label>
				<?php endforeach; ?>

				<small>
					<em><?php echo $params[ 'desc' ]; ?></em>
				</small>
			</td>
		</tr>
<?php
	}

	public function range_field( $key, $value, $params ) {
		extract( $params[ 'options' ] );
?>
		<tr>
			<td>
				<label for="<?php echo $key; ?>">
					<?php echo $params[ 'title' ]; ?>
				</label>
			</td>
			<td>
				<?php echo $value; ?>
				<input
					type="range"
					id="<?php echo $key; ?>"
					name="<?php echo $key; ?>"
					value="<?php echo $value; ?>"
					step="<?php echo $step; ?>"
					min="<?php echo $min; ?>"
					max="<?php echo $max; ?>"
				/>
				<small>
					<em><?php echo $params[ 'desc' ]; ?></em>
				</small>
			</td>
		</tr>
<?php
	}

	public function radio( $key, $value, $params ) {
?>
		<tr>
			<td>
				<?php echo $params[ 'title' ]; ?>
			</td>
			<td>
				<?php echo $value; ?>

					<?php foreach ( $params[ 'options' ] as $k => $v ) : ?>
						<label id="<?php echo $key; ?>">
							<input
								type="radio"
								name="<?php echo $key; ?>"
								value="<?php echo $k; ?>"
								<?php checked( $k, $value ); ?>
							/>

							<?php echo $v; ?>
						</label>						
					<?php endforeach; ?>

					<small>
						<em><?php echo $params[ 'desc' ]; ?></em>
					</small>
			</td>
		</tr>
<?php
	}

	public function url_field( $key, $value, $params ) {
?>
		<tr>
			<td>
				<label for="<?php echo $key; ?>">
					<?php echo $params[ 'title' ]; ?>
				</label>
			</td>
			<td>
				<?php echo $value; ?>
				<input
					type="url"
					id="<?php echo $key; ?>"
					name="<?php echo $key; ?>"
					value="<?php echo $value; ?>"
					pattern="<?php echo $params[ 'pattern' ]; ?>"
					required="<?php echo $params[ 'required' ] ? 'required' : ''; ?>"
				/>
				<small>
					<em><?php echo $params[ 'desc' ]; ?></em>
				</small>
			</td>
		</tr>
<?php
	}

	public function wp_editor( $key, $value, $params ) {
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
		<tr>
			<td>
				<?php echo $params[ 'title' ]; ?>
			</td>
			<td>
				<?php
					echo $value;

					wp_editor( $value, $key, $args );
				?>

				<small>
					<em><?php echo $params[ 'desc' ]; ?></em>
				</small>
			</td>
		</tr>
<?php
	}

	public function media_button( $key, $value, $params ) {
		$defaults = [
									'title' => 'Insert a media',
									'library' => [ 'type' => 'image' ],
									'multiple' => false,
									'button' => [ 'text' => 'Insert' ]
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
			$delBtnClass = 'briz-del-media-button-active';
		}
?>
		<tr>
			<td>
				<label>
					<?php echo $params[ 'title' ]; ?>
				</label>
			</td>
			<td>
				<input
					type="hidden"
					id="<?php echo $key; ?>"
					name="<?php echo $key; ?>"
					value="<?php echo $value ?>"
				/>
				<button
					type="button"
					class="button briz-media-button"
					data-title="<?php echo $title; ?>"
					data-library-type="<?php echo $library[ 'type' ]; ?>"
					data-multiple="<?php echo $multiple; ?>"
					data-button-text="<?php echo $button[ 'text' ]; ?>"
					data-action-text="<?php echo $edit_action_txt; ?>"
					data-stage="<?php echo $stage; ?>"
				>
					<!-- <span class="wp-media-buttons-icon"></span> -->
					<?php echo $btn_action_txt; ?>
				</button>
				<button
					type="button"
					class="button briz-del-media-button <?php echo $delBtnClass; ?>"
					data-action-text="<?php echo $add_action_txt; ?>"
				>
					<?php echo __( 'Удалить медиафайлы' ); ?>
				</button>
				<small>
					<em><?php echo $params[ 'desc' ]; ?></em>
				</small>
				<figure>
					<span class="briz-media-place">
<?php
							if ( $value ) :
								$value = json_decode( $value );
								if ( ! empty( $value ) ) :
									foreach ( $value as $media_id ) :
										// $src = wp_get_attachment_url( $media_id );
										$details = wp_prepare_attachment_for_js( $media_id );
										$src = $details[ 'url' ];

										// Helper::debug( get_post_meta( $media_id ) );
										// Helper::debug( wp_prepare_attachment_for_js( $media_id ) );

										if ( $caption = $details[ 'caption' ] ) :
?>
											<figcaption>
												<?php echo $caption; ?>
											</figcaption>
<?php
										endif;

										// Image
										if ( 'image' == $library[ 'type' ] ) :
											// $alt = trim( strip_tags( get_post_meta( $media_id, '_wp_attachment_image_alt', true ) ) );
?>
											<img
												src="<?php echo $src; ?>"
												alt="<?php echo $details[ 'alt' ]; ?>"
											/>
<?php
										elseif ( 'audio' == $library[ 'type' ] ) :
?>
											<audio src="<?php echo $src; ?>" controls></audio>
<?php
										elseif ( 'video' == $library[ 'type' ] ) :
?>
											<video src="<?php echo $src; ?>" controls></video>
<?php
										endif;
									endforeach;
								endif;
							endif;
?>
					</span>
				</figure>
			</td>
		</tr>
<?php
	}

	public function meta_box_save( $post_id, $post ) {
		// Helper::debug( __METHOD__, '200px' );
		// Helper::debug( $post_id, '200px' );
		// Helper::debug( $post, '200px' );

		// Helper::debug( $_POST );
		// Helper::debug( $this );

		// var_dump( $post_id );
		// Helper::debug( $_POST[ 'briz' ] );
		// exit;

		foreach ( $_POST[ 'briz' ] as $key => $val ) {
			if ( ! $val && $val !== '0' ) {
				delete_post_meta( $post_id, $key );
			} else {
				update_post_meta( $post_id, $key, $val );
			}
		}
	}
}
