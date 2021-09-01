<?php
namespace Briz_Shortcodes\inc;
use Briz_Shortcodes\Shortcodes;
use Briz_Shortcodes\common\Helper;

/**
 * Класс реализует шорткод "briz_tax",
 * который позволяет формировать
 * HTML разметку элемента.
 *
 * @property String $name         - имя шорткода.
 * @property String $tax_tmpl_ns  - пространство имён шаблонов записей термина.
 * @property Array $assets        - параметры подключаемых стилей и скриптов.
 * @property Array $inline_styles - inline стили.
 * @property Integer $n           - число участвующее в формировании уникального
 *                                  идентификатора для каждого шорткода.
 * @property Array $default_atts  {
 *  Доступные атрибуты:
 *
 *  @type String  $class         - дополнительные классы шорткода.
 *                                 Default: ''.
 *
 *  @type String  $term_id       - id терминов через запятую не повторяясь.
 *                                 Default: ''.
 *
 *  @type String  $operator      - как сравнивать указанные термины.
 *                                 Default: 'IN' - записи из указанных терминов.
 *                                 Accepts:
 *                                  'IN' - записи из указанных терминов (по умолчанию).
 *                                  'NOT IN' - записи из всех терминов, кроме
 *                                  указанных.
 *                                  'AND' - записи одновременно принадлежащие всем
 *                                  указанным терминам.
 *                                  'EXISTS' - записи из таксономии.
 *                                  'NOT EXISTS' - записи НЕ из таксономии.
 *
 *  @type Integer $self          - показвать ли записи родительского
 *                                  термина переданного в параметр $term_id.
 *                                  Default: 0.
 *                                  Accepts: 0, 1.
 *
 *  @type Integer $children      - показывать ли записи дочерних терминов
 *                                  термина переданного в параметр $term_id.
 *                                  Default: 0.
 *                                  Accepts: 0, 1.
 *
 *  @type Integer $grandchildren - показывать ли записи терминов потомков
 *                                  термина переданного в параметр $term_id.
 *                                  Default: 0.
 *                                  Accepts: 0, 1.
 *
 *  @type Integer $limit         - сколько выводить записей.
 *                                  Default: -1 ( все записи ).
 *
 *  @type Integer $offset        - сколько записей из запроса пропустить.
 *                                  Default: 0.
 *
 *  @type String  $orderby       - поля по которым можно сортировать записи.
 *                                  Default: 'id'
 *                                  Accepts:
 *                                   @see https://wp-kama.ru/function/wp_query#orderby
 *
 *  @type String  $order         - направление сортировки.
 *                                 Default: 'ASC'.
 *                                 Accepts: 'ASC', 'DESC'.
 *
 *  @type String  $meta_key      - !!! НЕ РЕАЛИЗОВАНО.
 *                                 получаем записи по ключам произвольных полей.
 *                                 Default: ''.
 *                                 Accepts:
 *                                  @see https://wp-kama.ru/function/wp_query#meta_query
 *
 *  @type Integer $show_more     - показывать ли кнопку "Показать ещё".
 *                                 Default: 1.
 *                                 Accepts: 0, 1.
 * }
 *
 * Пример:
 * [briz_tax
 *  term_id="44"
 *  operator="in"
 *  self="1"
 *  children="0"
 *  grandchildren="0"
 *  limit="1"
 *  offset="0"
 *  orderby="ID"
 *  order="ASC"
 *  meta_key="_wc_average_rating"
 *  show_more="1"
 *  class="tax-section"
 * ]
 *
 * @since 0.0.1
 * @author Ravil
 */
class Briz_Tax_Shortcode extends Shortcodes {
	public $name          = 'briz_tax';
	private $tax_tmpl_ns  = 'Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\\';
	public $assets        = [];
	public $inline_styles = [];
	public static $n      = 1;
	public $default_atts  = [
		'class'       => '',
		'term_id'     => '',
		'operator'    => 'IN',
		'self'        => 1,
		'children'    => 0,
		'grandchildren' => 0,
		'limit'       => -1,
		'offset'      => 0,
		'orderby'     => 'id',
		'order'       => 'ASC',
		'meta_key'    => '',
		'show_more'   => 1
	];


	/**
	 * Constructor.
	 *
	 * @param Object $obj - может принять другой объект в котором будет обрабатываться шорткод.
	 *
	 * @return void
	 *
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function __construct( $obj = '' ) {
		parent::__construct( $obj );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'add_ajax' ] );
		$this->set_ajax_handler();
	}


	/**
	 * Add an Ajax handler to add the remaining posts on button click "Show more".
	 *
	 * Добавляем Ajax обработчик для добавления оставшихся записей при нажатии кнопки
	 * "Показать ещё".
	 *
	 * @return void.
	 * @since Ravil.
	 */
	public function set_ajax_handler() {
		add_action( 'wp_ajax_get_more_posts', [ $this, 'get_more_posts' ] );
		add_action( 'wp_ajax_nopriv_get_more_posts', [ $this, 'get_more_posts' ] );
	}


	/**
	 * Define JS variable 'briz_tax_tmpl_ajax' in the frontend for Ajax requests.
	 *
	 * Определяем JS переменную 'briz_tax_tmpl_ajax' во фронтэнде для работы Ajax запросов.
	 *
	 * @return void.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function add_ajax() {
		wp_localize_script(
			'jquery',
			'briz_tax_tmpl_ajax',
			[
				'url'   => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'briz_tax_tmpl_ajax_nonce' )
			]
		);
	}


	/**
	 * Registering Styles and Scripts of templates.
	 *
	 * Регистрация стилей и скриптов шаблонов.
	 *
	 * @see Helper::join_assets()
	 * @link ~/common/helpers.php
	 *
	 * @return void.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function register_assets() {
		require_once( PLUGIN_PATH . 'extra/briz_tax_extra/meta/assets_paths.php' );
		$assets = apply_filters( "briz_tax_tmpls_assets", $assets );

		// Helper::debug( $assets );

		Helper::join_assets( $assets );
	}


	/**
	 * Tax shortcode callback.
	 *
	 * Функция обработчик шорткода "briz_tax".
	 *
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $content - контент переданный между парными тегами шорткода.
	 * @param String $tag     - имя шорткода указанный первым параметром
	 *                          в фукции "add_shortcode".
	 *
	 * @return String HTML    - разметка сформированного шорткода.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function shortcode_briz_tax( $atts, $content, $tag ) {
		$default_class = $this->get_full_name();
		$id            = $default_class . '_' . self::$n++;

		$content = wp_kses( $content, 'post' );

		$atts = $this->prepare_atts( $atts );

		$atts[ 'class' ] .= ( ! empty( $atts[ 'class' ] ) ) ? " $default_class" : $default_class;

		$atts[ 'offset' ] = absint( $atts[ 'offset' ] ) ?: 0;

		$atts[ 'limit' ] = ( int ) $atts[ 'limit' ] ?: -1;

		$atts[ 'show_more' ] = absint( $atts[ 'show_more' ] ) ?: 0;

		if ( ! empty( $atts[ 'operator' ] ) ) {
			$atts[ 'operator' ] = strtoupper( $atts[ 'operator' ] );
		}

		if ( ! empty( $atts[ 'order' ] ) ) {
			$atts[ 'order' ] = strtoupper( $atts[ 'order' ] );
		}

		$atts[ 'self' ] = ( bool ) $atts[ 'self' ];

		$atts[ 'children' ] = ( bool ) $atts[ 'children' ];

		$atts[ 'grandchildren' ] = ( bool ) $atts[ 'grandchildren' ];

		$term_ids = explode( ',', $atts[ 'term_id' ] );

		foreach ( $term_ids as $term_id ) {
			$term_id = ( int ) $term_id;
			if ( ! term_exists( $term_id ) )
				continue;

			$tmpl_path = get_term_meta( $term_id, 'tmpl', 1 );

			if ( $tmpl_path && -1 != $tmpl_path ) {
				$term = get_term( $term_id );
				$p_info = pathinfo( $tmpl_path );

				$taxonomy = $term->taxonomy;
				$all_offsets = $this->create_post_offset( $term_id, $taxonomy, $atts );

				$atts[ 'term' ][ $term_id ] = [
					'tmpl_name'   => $p_info[ 'filename' ],
					'tmpl_path'   => $tmpl_path,
					'taxonomy'    => $taxonomy,
					'all_offsets' => $all_offsets
				];
			}
		}

		// Helper::debug( $atts );

		Helper::add_to_session( $id, $atts );

		// $this->add_shortcode_style( $id, $atts );

		return $this->display_tax( $content, $atts, $id );
	}


	/**
	 * Display Termin.
	 *
	 * Формирует разметку элемента.
	 *
	 * @param Array  $content - текст элемента.
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $id      - атрибут элемента.
	 *
	 * @return String HTML    - разметка элемента.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function display_tax( $content, $atts, $id ) {
		if ( empty( $atts[ 'term' ] ) )
			return;

		$lang_domain = apply_filters( 'briz_shortcode_lang_domain', $this->lang_domain );

		// Helper::debug( $atts );

		ob_start();

		foreach ( $atts[ 'term' ] as $term_id => $term_data ) {
			$tmpl_source = $this->get_tmpl_source( $term_data );
			if ( ! $tmpl_source )
				continue;

			// Helper::debug( $term_data );

			$posts = $this->get_posts( $id, $term_id );

			$instance = new $tmpl_source( $content, $atts, $id, $lang_domain, $term_id );
			$instance->add_tmpl_assets();
			$instance->get_before( $posts );
			$instance->get_content( $posts );
			$instance->get_after( $posts );
		}

		return trim( ob_get_clean() );
	}


	/**
	 * Get a link to the term template class.
	 *
	 * Получаем ссылку на класс шаблона термина.
	 *
	 * @return String $tmpl_source.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function get_tmpl_source( $term_data ) {
		if ( ! file_exists( $term_data[ 'tmpl_path' ] ) )
			return false;

		include_once $term_data[ 'tmpl_path' ];
		$tmpl_source = $this->tax_tmpl_ns . ucfirst( $term_data[ 'tmpl_name' ] );
		if ( ! class_exists( $tmpl_source ) )
			return false;

		return $tmpl_source;
	}


	/**
	 * Get child terms, descendant terms depending on the search criteria.
	 * It is also possible to add a parent term to the list of child terms.
	 *
	 * Получаем дочерние термины, термины потомков в зависимости от критериев поиска.
	 * Также есть возможность добавить родительский термин в список дочерних терминов.
	 *
	 * @param Integer $parent_term - родительский термин.
	 * @param String $taxonomy     - таксономия родительского термина.
	 * @param Array $atts          - параметры переданные в шорткод.
	 *
	 * @return Array $res          - массив терминов.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function get_term_childrens( $parent_term, $taxonomy, $atts ) {
		$add_self = false;
		$parent = '';
		$child_of = $parent_term;

		// 1 - Записи только верхнего уровня ( родительские )
		// !!! - Проблемма бесконечное добавление ( Ajax ) записей
		if ( $atts[ 'self' ] && ! $atts[ 'children' ] && ! $atts[ 'grandchildren' ] ) {
			$parent = 0;
			$add_self = true;
		}

		// 2.1
		if ( ! $atts[ 'self' ] && $atts[ 'children' ] && ! $atts[ 'grandchildren' ] ) {
			$parent = $parent_term;
		}

		// 2.2
		if ( ! $atts[ 'self' ] && ! $atts[ 'children' ] && ! $atts[ 'grandchildren' ] ) {
			$parent = $parent_term;
		}

		// 4
		if ( $atts[ 'self' ] && $atts[ 'children' ] && ! $atts[ 'grandchildren' ] ) {
			$parent = $parent_term;
			$add_self = true;
		}

		// 5
		if ( $atts[ 'self' ] && $atts[ 'children' ] && $atts[ 'grandchildren' ] ) {
			// $child_of = $parent_term;
			$add_self = true;
		}

		$res = get_terms( [
			'taxonomy' => $taxonomy,
			'child_of' => $parent_term, // дочерние + потомки
			'parent' => $parent,
			// 'hide_empty' => false
		] );

		if ( $add_self ) {
			// добавление родителя ( portfolio )
			array_unshift( $res, get_term( $parent_term ) );
		}

		// Helper::debug( $res );

		return $res;
	}


	/**
	 * Determination of the primary indentation of posts, based on the value specified
	 * in the "offset" parameter when calling the shortcode.
	 *
	 * Определение первичного отступа записей, основываясь на значении указанном в
	 * параметре "offset" при вызове шорткода.
	 *
	 * @param Integer $term_id - id термина.
	 * @param String $taxonomy - таксономия родительского термина.
	 * @param Array $atts      - параметры переданные в шорткод.
	 *
	 * @return Array $all_offsets {
	 *  @type Integer $key   - id термина.
	 *  @type Integer $value - количество отступаемых записей термина.
	 * }
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function create_post_offset( $term_id, $taxonomy, $atts ) {
		$childrens = self::get_term_childrens( $term_id, $taxonomy, $atts );

		$all_offsets = [];
		foreach ( $childrens as $child ) {
			$id = $child->term_id;
			$all_offsets[ $id ] = $atts[ 'offset' ];
		}

		// Helper::debug( $all_offsets );

		return $all_offsets;
	}


	/**
	 * Determination of indentation of posts based on
	 * the parameters "offset" and "limit"
	 * passed during the call shortcode.
	 *
	 * Определение отступа записей основываясь на
	 * параметре "offset" и "limit" переданных при вызове шорткода.
	 *
	 * @param String $shortcode_id - id шорткода.
	 * @param Integer $shortcode_term_id - id термина.
	 * @param String/Integer $active_term_id - id активного шорткода. Accepts '', -1, id.
	 *
	 * @see Helper::add_to_session()
	 * @link ~/common/helpers.php
	 *
	 * @return void.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function set_post_offset( $shortcode_id, $shortcode_term_id, $active_term_id ) {
		if ( empty( $_SESSION[ $shortcode_id ] ) ) {
			return false;
		}

		$atts = json_decode( $_SESSION[ $shortcode_id ], true );
		extract( $atts );

		// Helper::debug( $active_term_id );

		if ( empty( $term[ $shortcode_term_id ][ 'all_offsets' ] ) ) {
			return false;
		}

		$all_offsets = $term[ $shortcode_term_id ][ 'all_offsets' ];

		if ( ! $active_term_id || -1 === $active_term_id ) {
			foreach ( $all_offsets as $k => $v ) {
				$all_offsets[ $k ] = $v + $limit;
			}
		} else {
			if ( ! array_key_exists( $active_term_id, $all_offsets ) )
				return false;

			$all_offsets[ $active_term_id ] += $limit;
		}

		// Helper::debug( $all_offsets );

		$atts[ 'term' ][ $shortcode_term_id ][ 'all_offsets' ] = $all_offsets;
		$atts[ 'offset' ] = $offset + $limit;

		Helper::add_to_session( $shortcode_id, $atts );
	}


	/**
	 * Getting term posts.
	 *
	 * Получаем записи терминов.
	 *
	 * @param String $shortcode_id       - id шорткода.
	 * @param Integer $shortcode_term_id - id термина.
	 * @param Integer $active_term_id    - id активного шорткода.
	 *        Default: 0.
	 *        Accepts: 0, -1, id.
	 *
	 * @return Array $result {
	 *   @type Array $atts - параметры шорткода.
	 *   @type Array {
	 *    @type WP_Term Object $child  - объект термина.
	 *    @type WP_Query Object $query - объект запроса.
	 *   }
	 * }
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function get_posts( $shortcode_id, $shortcode_term_id, $active_term_id = 0 ) {
		$result = [];

		if ( ! empty( $_SESSION[ $shortcode_id ] ) ) {
			$atts = json_decode( $_SESSION[ $shortcode_id ], true );
			extract( $atts );
			$result[ 'atts' ] = $atts;
		} else {
			wp_die( 'tmpl attrs empty or not exists in store' );
		}

		// Helper::debug( $atts );

		$taxonomy = $term[ $shortcode_term_id ][ 'taxonomy' ];
		$all_offsets = $term[ $shortcode_term_id ][ 'all_offsets' ];

		// Helper::debug( $all_offsets );

		if ( ! $active_term_id || -1 === $active_term_id ) {
			$childrens = array_map( function( $v ) {
				return get_term( $v );
			}, array_keys( $all_offsets ) );
		} else {
			$childrens[] = get_term( $active_term_id );
		}

		// Helper::debug( $childrens );

		foreach ( $childrens as $child ) {

			// Helper::debug( $child );

			$args = [
				'tax_query' => [
					[
						'taxonomy'         => $taxonomy,
						'terms'            => $child->term_id,
						'operator'         => $operator,
						'include_children' => false, // Включать или нет посты из дочерних терминов
						// 'include_children' => $children, // Включать или нет посты из дочерних терминов
					]
				],
				// 'post__not_in'   => $exclude,
				'posts_per_page' => $limit,
				'offset'         => $all_offsets[ $child->term_id ],
				// 'offset'         => $offset,
				'orderby'        => $orderby,
				'order'          => $order,
			];

			$query = new \WP_Query( $args );
			$data = [
				'child' => $child,
				'query' => $query
			];
			$result[ 'data' ][] = $data;
		}

		// Helper::debug( $result );

		return $result;
	}


	/**
	 * AJAX.
	 *
	 * Handle an Ajax request to get the remaining records
	 * of all terms or a selected term and return them.
	 *
	 * Обработка Ajax запроса на получение оставшихся записей
	 * всех терминов или выбраного термина и возврат их.
	 *
	 * @return JSON String.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function get_more_posts() {
		ob_start();
		// Helper::debug( session_id() );

		if ( empty( $_GET[ 'nonce' ] ) ) {
			wp_die( 'nonce is out' );
		}

		if ( ! wp_verify_nonce( $_GET[ 'nonce' ], 'briz_tax_tmpl_ajax_nonce' ) ) {
			wp_die( 'nonce do not match');
		}

		if ( ! empty( $_GET[ 'shortcode_id' ] ) ) {
			$shortcode_id = sanitize_text_field( $_GET[ 'shortcode_id' ] );
			// Helper::debug( $shortcode_id );
			if ( ! empty( $_SESSION[ $shortcode_id ] ) ) {
				$atts = json_decode( $_SESSION[ $shortcode_id ], true );
			} else {
				wp_die( 'Unknown shortcode id' );
			}
		} else {
			wp_die( 'Shortcode id is out' );
		}

		if ( ! empty( $_GET[ 'shortcode_term_id' ] ) && is_numeric( $_GET[ 'shortcode_term_id' ] ) ) {
			$shortcode_term_id = absint( $_GET[ 'shortcode_term_id' ] );
		} else {
			wp_die( 'Not sended term id' );
		}

		$active_term_id = 0;
		if ( ! empty( $_GET[ 'active_term_id' ] ) && is_numeric( $_GET[ 'active_term_id' ] ) ) {
			$active_term_id = ( int ) $_GET[ 'active_term_id' ];
			// Helper::debug( $active_term_id );
		}

		$this->set_post_offset( $shortcode_id, $shortcode_term_id, $active_term_id );

		$posts = $this->get_posts( $shortcode_id, $shortcode_term_id, $active_term_id );

		$tmpl_source = $this->get_tmpl_source( $atts[ 'term' ][ $shortcode_term_id ] );
		$instance = new $tmpl_source;
		$instance->get_content( $posts );

		echo json_encode( ob_get_clean() );

		wp_die();
	}
}
