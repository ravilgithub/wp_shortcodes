<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\meta;
use Briz_Shortcodes\common\Helper;

/**
 * The class implements the general functionality of meta fields.
 *
 * Класс реализует общий функционал мета полей.
 *
 * @property String $assets_id  - префикс id, JS и CSS файлов.
 * @property String $inc_path   - путь к HTML компонентам - мета полям.
 * @property String lang_domain - регистрационное "id" файла
 *                                переводов для всех шорткодов.
 *
 * @since 0.0.1
 * @author Ravil
 */
abstract class Meta {
	protected $assets_id = 'briz_meta';
	protected $inc_path  = PLUGIN_PATH . 'extra/briz_tax_extra/meta/inc/';
	protected $lang_domain;

	/**
	 * Constructor.
	 *
	 * @return void.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	protected function __construct() {
		$this->lang_domain = Helper::get_l10n_id();
		add_action( 'admin_enqueue_scripts', [ $this, 'load_media_files' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'add_assets' ] );
		$this->redefine_script_tag();
	}


	/**
	 * Includes all files required to use the WordPress media API.
	 *
	 * Подключает все файлы необходимые для использования медиа API WordPress.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function load_media_files() {
		wp_enqueue_media();
	}


	/**
	 * Add CSS and JS.
	 *
	 * Добавление стилей и скриптов.
	 *
	 * @return void.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function add_assets() {
		$assets = [
			'css' => [
				/************ CSS ************/
				[
					'id'   => $this->assets_id . '-css',
					'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/css/' . $this->assets_id . '.min.css',
					'deps' => [],
					'ver'  => '1.0.0'
				]
			],
			'js' => [
				/************ SCRIPTS ************/
				[
					'id'   => $this->assets_id . '-js',
					'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/js/' . $this->assets_id . '.js',
					'deps' => [ 'jquery' ],
					'ver'  => '1.0.0',
					'in_footer' => true
				]
			]
		];

		$assets = apply_filters( "{$this->assets_id}_assets", $assets );
		Helper::join_assets( $assets, false );
	}


	/**
	 * Adding a filter to override the attributes of the 'script' tag.
	 *
	 * Добавление фильтра для переопределения атрибутов тега 'script'.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 * */
	public function redefine_script_tag() {
		add_filter( 'script_loader_tag', [ $this, 'set_module_attr' ], 10, 3 );
	}


	/**
	 * We indicate that the script is a module and, accordingly
	 * will be able to import
	 * functionality from other modules.
	 *
	 * Указываем, что скрипт - это модуль и соответственно
	 * будет иметь возможность импортировать
	 * функционал из других модулей.
	 *
	 * @param String $tag    - HTML код тега <script>.
	 * @param String $handle - Название скрипта (рабочее название),
	 *                         указываемое первым параметром в
	 *                         функции wp_enqueue_script().
	 * @param String $src    - Ссылка на скрипт.
	 *
	 * @return String $tag   - HTML код тега <script>.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 * */
	public function set_module_attr( $tag, $handle, $src ) {
		$module_handle = $this->assets_id . '-js';
		if ( $module_handle === $handle )
			$tag = '<script type="module" src="' . $src . '" id="' . $module_handle . '-js"></script>';
		return $tag;
	}


	/**
	 * Sorting media files.
	 * Sorting is done by file type.
	 * The order of file types is specified in the meta field options in the 'type' parameter.
	 *
	 * Сортировка медиа файлов.
	 * Сортировка производится по типу файла.
	 * Порядок типов файлов указывается в опциях мета поля в параметре 'type'.
	 *
	 * @param JSON String $value - идентификаторы медиа файлов.
	 * @param Array $params - параметры мета поля.
	 *
	 * @return JSON String $ordered - отсортированные по типу идентификаторы медиа файлов.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function sort_attachment_files( $value, $params ) {
		$order = $params[ 'options' ][ 'library' ][ 'type' ];
		$value = json_decode( $value );

		if( ! is_array( $order ) )
			return json_encode( $value );

		if ( 2 > count( $order ) || 2 > count( $value ) )
			return json_encode( $value );

		$ordered = [];
		$stack = [];

		foreach ( $value as $media_id ) {
			$type = wp_prepare_attachment_for_js( $media_id )[ 'type' ];

			if ( array_key_exists( $type, $stack ) ) {
				array_push( $stack[ $type ], $media_id );
			} else {
				$stack[ $type ] = [ $media_id ];
			}
		}

		foreach ( $order as $type ) {
			if ( array_key_exists( $type, $stack ) )
				$ordered = array_merge( $ordered, $stack[ $type ] );
		}

		return json_encode( $ordered );
	}


	/**
	 * HTML markup of the button, when clicked, the values
	 * of the meta fields are reset and the default values are set.
	 *
	 * HTML разметка кнопки при нажатии на которую, сбрасываются значения
	 * мета полей и устанавливаются значения по умолчанию.
	 *
	 * @param WP_Term Object $tag - текущий объект термина таксономии.
	 * @param String $category    - ярлык текущий таксономии.
	 *
	 * @param String $meta_box_id - уникальный идентификатор мета бокса
	 *                              на странице редактирования записи.
	 *   @used ./post/meta_boxes.php
	 *    @see method "meta_box"
	 *   @used ./term/term_meta.php
	 *    @see action "{$tax_name}_edit_form_fields"
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function add_reset_all_btn( $tag, $category, $meta_box_id = '' ) {
?>
		<tr>
			<td colspan="2" class="briz-meta-reset-all-btn-cell">
				<button
					type="button"
					class="button briz-meta-reset-all"
					data-meta-box-id="<?php echo esc_attr( $meta_box_id ); ?>"
					data-test="test"
				><?php _e( 'Reset all', $this->lang_domain ); ?></button>
			</td>
		</tr>
<?php
	}


	/**
	 * Connecting the HTML component of the meta field.
	 *
	 * Подключение HTML комонента мета поля.
	 *
	 * @param Array $params - параметры мета поля.
	 * @param String $key   - имя мета поля.
	 * @param String $value - значение мета поля.
	 * @param String $method_suffix - суффикс названия подключаемого компонента.
	 *                                Possible: '' | '_edit'
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function require_component( $key, $value, $params, $component_suffix, $saved ) {
		$component_name = $params[ 'type' ] . $component_suffix;
		$component_path = $this->inc_path . $component_name . '.php';
		$filter_id = 'briz_meta_' . $component_name . '_component';

		ob_start();
		require apply_filters( $filter_id, $component_path, $key, $value, $params, $component_suffix, $saved );
		return ob_end_flush();
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
	public function fields_iterator( $meta, $fields = null, $group_name = '', $path = [] ) {
		// Helper::debug( $meta );
		$tax = $meta[ 'taxonomy' ];
		$tmpl = $meta[ 'tmpl' ];
		$fields = $fields ?: $meta[ 'fields' ];

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

				$color = $this->get_random_color();
				$this->decorate_group( 'Start', $color, $params, $meta );
				$this->fields_iterator( $meta, $params[ 'value' ], $gn, $pth );
				$this->decorate_group( 'End', $color, $params, $meta );

				continue;
			}

			// Имя мета поля или группы мета полей верхнего уровня( группа находящаяся в массиве "fields" )
			$fn = $group_name ?: $name;

			$key = '_' . $tax . '_' . $tmpl;

			$component_suffix = '_edit';

			if ( 'post' === $meta[ 'page' ] ) {
				$post_meta = get_post_meta( $meta[ 'id' ], $key, true );
			} elseif ( 'term' === $meta[ 'page' ] ) {
				$post_meta = get_term_meta( $meta[ 'id' ], $key, true );
				if ( 'add' === $meta[ 'action' ] ) {
					$component_suffix = '';
				}
			}

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

			$this->require_component( $key, $value, $params, $component_suffix, $saved );

			// Helper::debug( get_current_screen() );
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
	public function decorate_group( $position, $color, $field_params, $meta ) {
		if ( array_key_exists( 'color', $field_params ) && $field_params[ 'color' ] ) {
			$color = $field_params[ 'color' ];
		}

		$style = 'background:' . $color . ';';
		$title = $position . ' ' . $field_params[ 'title' ];

		if ( 'term' == $meta[ 'page' ] && 'add' == $meta[ 'action' ] ) :
?>
			<div
				class="briz_meta_box_group_name"
				style="<?php echo esc_attr( $style ); ?> padding: 10px;">
				<span><?php _e( $title, $this->lang_domain ); ?></span>
			</div>
<?php
		else :
?>
		<tr class="briz_meta_box_group_name" style="<?php echo esc_attr( $style ); ?>">
			<td colspan="2"><?php _e( $title, $this->lang_domain ); ?></td>
		</tr>
<?php
		endif;
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
}
