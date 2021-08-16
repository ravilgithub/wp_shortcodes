<?php
namespace Bri_Shortcodes;

/**
 * The class adds meta boxes for posts.
 *
 * Класс добавляет метабоксы для записей.
 *
 * @property Array $screens    - типы записей к которым допустимо добавлять метаблок.
 * @property Array $taxs       - таксономии к записям которых добавляются метабоксы.
 * @property String $id_prefix - префикс идентификатора метабокса и его полей.
 * @property Array $opts       - параметры полей по умолчанию.
 *
 * @since 0.0.1
 * @author Ravil
 */
class Meta_boxes extends Meta {
	public $screens;
	public $taxs;
	public $id_prefix = 'briz_meta_box';
	public $opts      = [];
	private $is_group = false;


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
		$this->taxs = $taxs;
		$this->screens = $screens;

		parent::__construct();

		require_once( PLUGIN_PATH . 'extra/bri_tax_extra/meta/meta_opts.php' );
		$this->opts = apply_filters( "{$this->id_prefix}_opts", $opts );

		add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ], 10, 2 );
		add_action( 'save_post', [ $this, 'meta_box_save' ], 1, 2 );
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
			}
		}

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

			add_meta_box( "{$this->id_prefix}_{$n}", $title, $callback, $this->screens, 'advanced', 'default', $callback_args );
		}
	}


	/**
	 * Decorating groups.
	 *
	 * Декорирование групп.
	 *
	 * @param String $position    - префикс имени группы.
	 * @param Array $field_params - параметры и мета поля группы.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function decorate_group( $position, $field_params ) {
		$rgb = $this->get_random_color();
		$color = implode( ',', $rgb );
		$style = 'background: rgb(' . $color . ');';
		$label = $position . ' ' . $field_params[ 'title' ];
?>
		<tr class="briz_meta_box_group_name" style="<?php echo esc_attr( $style ); ?>">
			<td colspan="2"><?php _e( $label ); ?></td>
		</tr>
<?php
	}


	/**
	 * A random background color to represent the group.
	 *
	 * Случайный фоновый цвет для обозначения группы.
	 *
	 * @return Array $rgb_color - цвет в формате rgb.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function get_random_color() {
		$rgb_color = [];
		foreach( [ 'r', 'g', 'b' ] as $color ) {
			$rgb_color[ $color ] = mt_rand( 150, 225 );
		}
		return $rgb_color;
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

				$rgb = $this->get_random_color();
				$color = implode( ',', $rgb );
				$style = 'background: rgb(' . $color . ');';

				$this->decorate_group( 'Start', $field_params );

				$this->fields_iterator( $post, $meta, $field_params[ 'value' ], $gn, $pth );

				$this->decorate_group( 'End', $field_params );

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
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/text_edit.php';
		require apply_filters( 'briz_meta_text_component', $component_path, $key, $value, $params );
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
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/textarea_edit.php';
		require apply_filters( 'briz_meta_textarea_edit_component', $component_path, $key, $value, $params );
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
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/color_edit.php';
		require apply_filters( 'briz_meta_color_edit_component', $component_path, $key, $value, $params );
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
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/number_edit.php';
		require apply_filters( 'briz_meta_number_edit_component', $component_path, $key, $value, $params );
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
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/select_edit.php';
		require apply_filters( 'briz_meta_select_edit_component', $component_path, $key, $value, $params );
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
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/checkbox_edit.php';
		require apply_filters( 'briz_meta_checkbox_edit_component', $component_path, $key, $value, $params );
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
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/range_edit.php';
		require apply_filters( 'briz_meta_range_edit_component', $component_path, $key, $value, $params );
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
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/radio_edit.php';
		require apply_filters( 'briz_meta_radio_edit_component', $component_path, $key, $value, $params );
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
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/url_edit.php';
		require apply_filters( 'briz_meta_url_edit_component', $component_path, $key, $value, $params );
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
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/wp_editor_edit.php';
		require apply_filters( 'briz_meta_wp_editor_edit_component', $component_path, $key, $value, $params );
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
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/media_button_edit.php';
		require apply_filters( 'briz_meta_media_button_edit_component', $component_path, $key, $value, $params );
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
		if ( ! isset( $_POST[ $this->id_prefix ] ) )
			return;

		foreach ( $_POST[ $this->id_prefix ] as $key => $val ) {
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
		'screens'    => [ 'post', 'product' ],
		'taxonomies' => [ 'category', 'product_cat' ]
	];

	$atts = apply_filters( 'BRI_Meta_Boxes_Atts', $atts );

	if ( empty( $atts ) )
		return;

	extract( $atts );
	$meta_boxes = new Meta_Boxes( $screens, $taxonomies );
}

add_action( 'admin_init', __NAMESPACE__ . '\\meta_boxes_init' );
