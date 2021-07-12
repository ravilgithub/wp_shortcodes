<?php
namespace Bri_Shortcodes;

/**
 * The class adds meta boxes for posts.
 *
 * Класс добавляет метабоксы для записей.
 *
 * @property Array $screens    - типы записей к которым допустимо добавлять метаблок.
 * @property Array $taxs       - таксономии к записям которых добавляются метабоксы.
 * @property String $id_prefix - префикс идентификатора метабокса и его полей. Default: "briz".
 * @property Array $opts       - параметры полей по умолчанию.
 *
 * @since 0.0.1
 * @author Ravil
 */
class Meta_boxes {
	public $screens;
	public $taxs;
	public $id_prefix = 'briz';
	public $opts      = [];


	/**
	 * Constructor
	 *
	 * @param Array $screens - типы записей к которым допустимо добавлять метаблок.
	 * @param Array $taxs    - таксономии к записям которых добавляются метабоксы.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function __construct( $screens, $taxs ) {
		// Helper::debug( __CLASS__, '200px' );
		$this->taxs = $taxs;
		$this->screens = $screens;

		// Helper::debug( PLUGIN_PATH . 'extra/bri_tax_extra/meta/meta_opts.php', '200px' );

		require_once( PLUGIN_PATH . 'extra/bri_tax_extra/meta/meta_opts.php' );
		$this->opts = apply_filters( "{$this->id_prefix}_meta_opts", $opts );
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

		$assets = apply_filters( "{$this->id_prefix}_metabox_assets", $assets );

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


	/**
	 * Collection of template names according to which the output of term posts is formed,
	 * including the names of templates of parent terms, if any.
	 *
	 * Сбор имён шаблонов согласно которым формируется вывод записей терминов,
	 * в том числе имена шаблонов родительских терминов если они есть.
	 *
	 * @param Object $post - Объект записи: объект WP_Post.
	 *
	 * @return Array $term_info {
	 *   @type Array $tmpl - массив имён шаблонов.
	 *   @type String $taxonomy - имя таксономии к которой относятся термины.
	 * }
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
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

							if ( '' !== $tmpl_path && -1 != $tmpl_path ) {
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


	/**
	 * Collecting data for the formation of the metabox.
	 *
	 * Сбор данных для формирования метабокса.
	 *
	 * @param String $post_type - Название типа записи, на странице редактирования которой вызывается хук.
	 * @param Object $post - Объект записи: объект WP_Post.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function add_meta_box( $post_type, $post ) {
		// Helper::debug( __METHOD__, '200px' );
		// Helper::debug( $post_type, '200px' );
		// Helper::debug( $post, '200px' );

		$callback = [ $this, 'meta_box' ];
		$terms_info = $this->get_terms_info( $post );

		/**
		 * Добавляем метаблок только указанным типам записи.
		 */
		if ( ! in_array( $post_type, $this->screens ) ) {
			return;
		}

		$n = 0;
		foreach ( $terms_info[ 'tmpl' ] as $tmpl ) {
			$n++;
			$title = __( "Options for term template: " ) . ucfirst( $tmpl );

			$tax = $terms_info[ 'taxonomy' ];

			if (
				! array_key_exists( $tax, $this->opts ) ||
				! array_key_exists( $tmpl, $this->opts[ $tax ] ) ||
				empty( $this->opts[ $tax ][ $tmpl ][ 'fields' ] )
			) {
				continue;
			}

			$callback_args[ 'fields' ] = $this->opts[ $tax ][ $tmpl ][ 'fields' ];
			$callback_args[ 'taxonomy' ] = $tax;
			$callback_args[ 'tmpl' ] = $tmpl;

			// Helper::debug( $tmpl, '200px' );

			add_meta_box( "{$this->id_prefix}_meta_box_{$n}", $title, $callback, $this->screens, 'advanced', 'default', $callback_args );
		}
	}


	/**
	 * Enumeration of meta fields obtained from the database or from the "meta_opts.php" file.
	 *
	 * Перебор мета полей полученных из базы данных или из файла "meta_opts.php".
	 *
	 * @param Object $post - Объект записи: объект WP_Post.
	 * @param Array $meta - Данные поста ( объект $post ) и аргументы переданные в этот параметр.
	 *   @see add_meta_box( ...$callback_args )
	 * @param Array $fields - Массив мета полей. Default: null.
	 * @param String $group_name - Имя группы верхнего уровня
	 *                             ( группа находящаяся в массиве "fields" в файле "meta_opts.php" ).
	 *                             Default: ''.
	 * @param Array $path - Массив имён групп полей начиная от родительской к дочерней,
	 *                      которые в свою очередь находятся в группе верхнего
	 *                      уровня( группа находящаяся в массиве "fields" )
	 *                      в файле "meta_opts.php".
	 *                      Служат для нахождения группы после выборки из базы данных.
	 *                      Default: empty Array.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function fields_iterator( $post, $meta, $fields = null, $group_name = '', $path = [] ) {
		$tax = $meta[ 'args' ][ 'taxonomy' ];
		$tmpl = $meta[ 'args' ][ 'tmpl' ];
		$fields = $fields ?: $meta[ 'args' ][ 'fields' ];

		foreach ( $fields as $field_name => $field_params ) {
			if ( 'group' == $field_params[ 'type' ] ) {
				// echo '<tr style="background: #ffeeee; padding: 20px 0 10px;"><td colspan="2">' . $field_params[ 'title' ] . '</td></tr>';

				/**
				* Переменный $gn и $pth созданы для того что бы
				* не переписывать переменные $group_name и $path
				* используемые в текущем вызове функции fields_iterator.
				*/
				$gn = $group_name ?: $field_name;
				$pth = $path;

				// Собераем имена дочерних групп "группы верхнуго уровня".
				if ( $group_name && $field_name != $group_name ) {
					$pth[] = $field_name;
				}

				$this->fields_iterator( $post, $meta, $field_params[ 'value' ], $gn, $pth );

				// echo '<tr style="height: 1px; line-height: 1px; background: #000; padding: 10px 0 20px;"><td colspan="2"></td></tr>';
				continue;
			}

			// Имя мета поля или группы мета полей верхнего уровня( группа находящаяся в массиве "fields" )
			$fn = $group_name ?: $field_name;

			$field_key = '_' . $tax . '_' . $tmpl;
			$field_value = get_post_meta( $post->ID, $field_key, true );

			if ( $field_value ) {
				if ( is_array( $field_value ) && array_key_exists( $fn, $field_value ) ) {
					$field_value = $field_value[ $fn ];
				} else {
					// Новое мета поле которого нет в БД. Файл "meta_opts.php".
					$field_value = $field_params[ 'value' ];
				}
			} else {
				// Если в БД ничего нет. Файл "meta_opts.php".
				$field_value = $field_params[ 'value' ];
			}

			// В этом блоке работаем с данными пришедшими из БД.
			if (
				! empty( $field_value ) &&
				is_array( $field_value ) &&
				 // Так узнаём, что значение является ассоциативным массивам т.е. группой.
				'{' === json_encode( $field_value )[ 0 ]
			) {
				if ( ! empty( $field_value[ $field_name ] ) && ( empty( $path ) || ! is_array( $field_value[ $field_name ] ) ) ) {
					// Значение поля не являющейся группой.
					$field_value = $field_value[ $field_name ];
				} else {
					$group = null;

					// Находим группу в выборке из базы данных, если её нет, то значит это новая группа( $field_params ).
					for ( $n = 0; $n < count( $path ); $n++ ) {
						if ( ! $group ) {
							$group = array_key_exists( $path[ $n ], $field_value ) ? $field_value[ $path[ $n ] ] : $field_params;
						} else {
							$group = array_key_exists( $path[ $n ], $group ) ? $group[ $path[ $n ] ] : $field_params;
						}
					}

					// Получаем значение поля группы.
					if ( is_array( $group ) && array_key_exists( $field_name, $group ) ) {
						$field_value = $group[ $field_name ];
					} else {
						// Если в группу добавленно новое поле, то берём его значение по умолчанию. Файл "meta_opts.php".
						$field_value = $field_params[ 'value' ];
					}
				}
			}

			// Создаём значения атрибутов "name" мета полей.
			if ( $group_name ) {
				$part = ! empty( $path ) ? '[' . implode( '][', $path ) . ']' : '';
				$field_key = $this->id_prefix . "[$field_key][$fn]" . $part . "[$field_name]";
			} else {
				$field_key = $this->id_prefix . "[$field_key][$fn]";
			}

			$method = $field_params[ 'type' ];
			if ( method_exists( $this, $method ) ) {
				$this->$method( $field_key, $field_value, $field_params );
			}
		}
	}


	/**
	 * HTML output meta box content.
	 *
	 * Вывод HTML содержание метабокса.
	 *
	 * @param Object $post - Объект записи: объект WP_Post.
	 * @param Array $meta - данные поста (объект $post) и аргументы переданные в этот параметр.
	 *   @see add_meta_box( ...$callback_args )
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function meta_box( $post, $meta ) {
		// Helper::debug( __METHOD__, '200px' );
		// Helper::debug( $post, '200px' );
		// Helper::debug( $meta, '200px' );
?>
		<div class="briz_meta_box_wrap">
			<table width="100%">
				<thead>
				<tr>
					<th width>Имя</th>
					<th width>Значение</th>
				</tr>
				</thead>
				<tbody>
					<?php
						$this->fields_iterator( $post, $meta );
					?>
				</tbody>
			</table>
		</div>
<?php
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param String $key - имя мета поля.
	 * @param String $value - значение мета поля.
	 * @param Array $params - параметры мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function text( $key, $value, $params ) {
		// $bg_color = $params[ 'color' ] ?: '';
?>
		<!-- <tr style="background-color: <?php // echo esc_attr( $bg_color ); ?>;"> -->
		<tr>
			<td>
				<span class="briz_meta_field_title">
					<?php echo $params[ 'title' ]; ?>
				</span>
			</td>
			<td>
				<?php echo $value; ?>
				<input type="text" name="<?php echo $key; ?>" value="<?php echo $value; ?>"/>
				<small>
					<em><?php echo $params[ 'desc' ]; ?></em>
				</small>
			</td>
		</tr>
<?php
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param String $key - имя мета поля.
	 * @param String $value - значение мета поля.
	 * @param Array $params - параметры мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function textarea( $key, $value, $params ) {
?>
		<tr>
			<td>
				<span class="briz_meta_field_title">
					<?php echo $params[ 'title' ]; ?>
				</span>
			</td>
			<td>
				<textarea name="<?php echo $key; ?>"><?php echo $value; ?></textarea>
				<small>
					<em><?php echo $params[ 'desc' ]; ?></em>
				</small>
			</td>
		</tr>
<?php
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param String $key - имя мета поля.
	 * @param String $value - значение мета поля.
	 * @param Array $params - параметры мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function color( $key, $value, $params ) {
?>
		<tr>
			<td>
				<span class="briz_meta_field_title">
					<?php echo $params[ 'title' ]; ?>
				</span>
			</td>
			<td>
				<?php echo $value; ?>
				<input type="color" name="<?php echo $key; ?>" value="<?php echo $value; ?>"/>
				<small>
					<em><?php echo $params[ 'desc' ]; ?></em>
				</small>
			</td>
		</tr>
<?php
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param String $key - имя мета поля.
	 * @param String $value - значение мета поля.
	 * @param Array $params - параметры мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */

	public function number( $key, $value, $params ) {
		extract( $params[ 'options' ] );
?>
		<tr>
			<td>
				<span class="briz_meta_field_title">
					<?php echo $params[ 'title' ]; ?>
				</span>
			</td>
			<td>
				<?php echo $value; ?>
				<input
					type="number"
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


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param String $key - имя мета поля.
	 * @param String $value - значение мета поля.
	 * @param Array $params - параметры мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */

	public function select( $key, $value, $params ) {
?>
		<tr>
			<td>
				<span class="briz_meta_field_title">
					<?php echo $params[ 'title' ]; ?>
				</span>
			</td>
			<td>
				<?php echo $value; ?>
				<select name="<?php echo $key; ?>">
					<?php foreach ( $params[ 'options' ] as $k => $v ) : ?>	
						<option value="<?php echo $k; ?>" <?php selected( $value, $k, true ); ?>><?php echo $v; ?></option>
					<?php endforeach; ?>
				</select>
				<small>
					<em><?php echo $params[ 'desc' ]; ?></em>
				</small>
			</td>
		</tr>
<?php
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param String $key - имя мета поля.
	 * @param String $value - значение мета поля.
	 * @param Array $params - параметры мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function checkbox( $key, $value, $params ) {
?>
		<tr>
			<td>
				<span class="briz_meta_field_title">
					<?php echo $params[ 'title' ]; ?>
				</span>
			</td>
			<td>

				<!-- Если checkbox'ы не выбраны то в $_POST будет пустое поле, что позволит удалить его из БД. -->
				<input type="hidden" name="<?php echo $key; ?>" value="">

				<?php Helper::debug( (array) $value ); ?>

				<?php foreach ( $params[ 'options' ] as $k => $v ) : ?>
					<label>
						<input
							type="checkbox"
							name="<?php echo $key . '[]'; ?>"
							value="<?php echo $k; ?>"
							<?php checked( true, in_array( $k, (array) $value ) ); ?>
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


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param String $key - имя мета поля.
	 * @param String $value - значение мета поля.
	 * @param Array $params - параметры мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function range( $key, $value, $params ) {
		extract( $params[ 'options' ] );
?>
		<tr class="briz-meta-field-range-wrap">
			<td>
				<span class="briz_meta_field_title">
					<?php echo $params[ 'title' ]; ?>
				</span>
			</td>
			<td>

				<p>
					<?php _e( 'Current value' ); ?>:
					<span class="briz-range-current-value">
						<?php echo $value; ?>
					</span>
				</p>

				<input
					type="range"
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


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param String $key - имя мета поля.
	 * @param String $value - значение мета поля.
	 * @param Array $params - параметры мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function radio( $key, $value, $params ) {
?>
		<tr>
			<td>
				<span class="briz_meta_field_title">
					<?php echo $params[ 'title' ]; ?>
				</span>
			</td>
			<td>
				<?php echo $value; ?>

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

					<small>
						<em><?php echo $params[ 'desc' ]; ?></em>
					</small>
			</td>
		</tr>
<?php
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param String $key - имя мета поля.
	 * @param String $value - значение мета поля.
	 * @param Array $params - параметры мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function url( $key, $value, $params ) {
?>
		<tr>
			<td>
				<span class="briz_meta_field_title">
					<?php echo $params[ 'title' ]; ?>
				</span>
			</td>
			<td>
				<?php echo $value; ?>
				<input
					type="url"
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


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param String $key - имя мета поля.
	 * @param String $value - значение мета поля.
	 * @param Array $params - параметры мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
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
				<span class="briz_meta_field_title">
					<?php echo $params[ 'title' ]; ?>
				</span>
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


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param String $key - имя мета поля.
	 * @param String $value - значение мета поля.
	 * @param Array $params - параметры мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function media_button( $key, $value, $params ) {
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
			$delBtnClass = 'briz-del-media-button-active';
		}
?>
		<tr>
			<td>
				<span class="briz_meta_field_title">
					<?php echo $params[ 'title' ]; ?>
				</span>
			</td>
			<td>
				<input
					type="hidden"
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
										$details = wp_prepare_attachment_for_js( $media_id );
										$src = $details[ 'url' ];

										if ( $caption = $details[ 'caption' ] ) :
?>
											<figcaption>
												<?php echo $caption; ?>
											</figcaption>
<?php
										endif;

										// Image
										if ( 'image' == $library[ 'type' ] ) :
?>
											<img
												src="<?php echo $src; ?>"
												alt="<?php echo $details[ 'alt' ]; ?>"
											/>
<?php
										// Audio
										elseif ( 'audio' == $library[ 'type' ] ) :
?>
											<audio src="<?php echo $src; ?>" controls></audio>
<?php
										// Video
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

				<?php
					// global $wp_meta_boxes;
					// Helper::debug( $wp_meta_boxes );
				?>
			</td>
		</tr>
<?php
	}


	/**
	 * Saving, changing or deleting the values of the meta fields of the posts.
	 *
	 * Сохранение, изменение или удаление значений мета полей записи.
	 *
	 * @param String $post_id - ID записи, которая обновляется.
	 * @param Object $post - Объект записи: объект WP_Post.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function meta_box_save( $post_id, $post ) {
		// Helper::debug( __METHOD__, '200px' );
		// Helper::debug( $post_id, '200px' );
		// Helper::debug( $post, '200px' );

		// Helper::debug( $_POST );
		// Helper::debug( $this );

		// var_dump( $post_id );
		// Helper::debug( $_POST[ 'briz' ] );
		// exit;

		if ( ! isset( $_POST[ 'briz' ] ) )
			return;

		foreach ( $_POST[ 'briz' ] as $key => $val ) {
			if ( ! $val && $val !== '0' ) {
				delete_post_meta( $post_id, $key );
			} else {
				update_post_meta( $post_id, $key, $val );
			}
		}
	}
}


/**
 * Initializing Class Meta_Boxes.
 *
 * Инициализация класса Meta_Boxes.
 *
 * @return void
 *
 * @since 0.0.1
 * @author Ravil
 */
function meta_boxes_init() {
	$atts = [
		// 'tmpls_dir'  => 'Meta_Boxes',
		'screens'    => [ 'post', 'product' ],
		'taxonomies' => [ 'category', 'product_cat' ]
	];

	$atts = apply_filters( 'BRI_Meta_Boxes_Atts', $atts );

	if ( empty( $atts ) )
		return;

	extract( $atts );
	// $meta_boxes = new Meta_Boxes( $tmpls_dir, $screens, $taxonomies );
	$meta_boxes = new Meta_Boxes( $screens, $taxonomies );
}

add_action( 'admin_init', __NAMESPACE__ . '\\meta_boxes_init' );
