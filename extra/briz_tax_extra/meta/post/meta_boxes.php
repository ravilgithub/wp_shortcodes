<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\meta\post;
use Briz_Shortcodes\extra\briz_tax_extra\meta\Meta;
use Briz_Shortcodes\common\Helper;

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
class Meta_Boxes extends Meta {
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

		require_once( PLUGIN_PATH . 'extra/briz_tax_extra/meta/post/opts.php' );
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
		if ( array_key_exists( 'color', $field_params ) && $field_params[ 'color' ] ) {
			$color = $field_params[ 'color' ];
		} else {
			$color = $this->get_random_color();
		}

		$style = 'background:' . $color . ';';
		$title = $position . ' ' . $field_params[ 'title' ];
?>
		<tr class="briz_meta_box_group_name" style="<?php echo esc_attr( $style ); ?>">
			<td colspan="2"><?php _e( $title ); ?></td>
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
		return 'rgb(' . implode( ',', $rgb_color ) . ')';
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

		foreach ( $fields as $name => $params ) {
			if ( 'group' == $params[ 'type' ] ) {
				/**
				* Переменный $gn и $pth созданы для того что бы
				* не переписывать переменные $group_name и $path ( ссылочная система )
				* используемые в текущем вызове функции fields_iterator.
				*/
				$gn = $group_name ?: $name;

				// Собераем имена групп.
				$pth = $path;
				if ( $name != $group_name ) {
					$pth[] = $name;
				}

				$this->decorate_group( 'Start', $params );
				$this->fields_iterator( $post, $meta, $params[ 'value' ], $gn, $pth );
				$this->decorate_group( 'End', $params );

				continue;
			}

			// Имя мета поля или группы мета полей верхнего уровня( группа находящаяся в массиве "fields" )
			$fn = $group_name ?: $name;

			$key = '_' . $tax . '_' . $tmpl;
			$post_meta = get_post_meta( $post->ID, $key, true );
			$saved = false;

			if ( ! empty( $post_meta ) ) {
				// В этом блоке работаем с данными пришедшими из БД.
				if (
					// Ищем в результате выборки из БД, текущее мета поле или группу полей верхнего уровня +
					is_array( $post_meta ) && array_key_exists( $fn, $post_meta )
				) {
					if (
						! $post_meta[ $fn ] &&
						'0' !== $post_meta[ $fn ] &&
						(
							! array_key_exists( 'empty', $params ) ||
							! $params[ 'empty' ]
						)
					) {
						$value = $params[ 'value' ];
					} else {
						$value = $post_meta[ $fn ]; // верхний уровень
						$saved = true;

						// Так узнаём, что значение является ассоциативным массивом т.е. группой.
						if ( '{' === json_encode( $value )[ 0 ] ) {
							$group = null;
							$saved = false;

							if ( 1 < count( $path ) ) {
								// Находим группу в выборке из базы данных, если её нет, то значит текущее мета поле( $params ) принадлежит новой группе.
								for ( $n = 1; $n < count( $path ); $n++ ) {
									if ( ! $group ) {
										$group = array_key_exists( $path[ $n ], $value ) ? $value[ $path[ $n ] ] : $params;
									} else {
										$group = array_key_exists( $path[ $n ], $group ) ? $group[ $path[ $n ] ] : $params;
									}
								}
							} else {
								// Группа верхнего уровня.
								$group = $value;
							}

							if ( is_array( $group ) && array_key_exists( $name, $group ) ) {
								if (
									! $group[ $name ] &&
									'0' !== $group[ $name ] &&
									(
										! array_key_exists( 'empty', $params ) ||
										! $params[ 'empty' ]
									)
								) {
									// Значение не можен быть пустым. берём его значение по умолчанию. Файл "opts.php".
									// Default "opts.php" мета поля НЕ! верхнего уровня.
									$value = $params[ 'value' ];
								} else {
									$value = $group[ $name ];
									$saved = true;
								}
							} else {
								// Если в группу добавленно новое поле, то берём его значение по умолчанию. Файл "opts.php".
								$value = $params[ 'value' ];
							}
						}
					}
				} else {
					// Новое мета поле которого нет в БД. Файл "meta_opts.php".
					// Добавили новое мета поле type=любой +
					// Default "opts.php" мета поля верхнего уровня.
					$value = $params[ 'value' ];
				}
			} else {
				// Если в БД ничего нет. Файл "meta_opts.php".
				// Значение мета поля ( не группа ) +
				$value = $params[ 'value' ];
			}

			// Создаём значения атрибутов "name" мета полей.
			if ( $group_name ) {
				$part = ! empty( $path ) ? '[' . implode( '][', $path ) . ']' : '';
				$key = $this->id_prefix . "[$key]" . $part . "[$name]";
			} else {
				$key = $this->id_prefix . "[$key][$name]";
			}

			// Сортировка медиа файлов.
			if ( 'media_button' === $params[ 'type' ] && $value && '[]' !== $value ) {
				$value = $this->sort_attachment_files( $value, $params );
			}

			$this->require_component( $key, $value, $params, '_edit', $saved );
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

	$atts = apply_filters( 'BRIZ_Meta_Boxes_Atts', $atts );

	if ( empty( $atts ) )
		return;

	extract( $atts );
	$meta_boxes = new Meta_Boxes( $screens, $taxonomies );
}

add_action( 'admin_init', __NAMESPACE__ . '\\meta_boxes_init' );
