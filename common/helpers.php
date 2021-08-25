<?php
namespace Briz_Shortcodes;

/**
 * Helper class for "briz_tax" shortcodes.
 *
 * Вспомогательный класс для "briz_tax" шорткодов.
 *
 * @since 0.0.1
 * @author Ravil.
 */
class Helper {

	/**
	 * Constructor.
	 *
	 * @return void.
	 *
	 * @since 0.0.1
	 * @author Ravil.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'create_session' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_shortcodes_vendors' ] );
	}


	/**
	 * Create session.
	 *
	 * Создаём сессию.
	 *
	 * @return void.
	 *
	 * @since 0.0.1
	 * @author Ravil.
	 */
	public function create_session() {
		if ( ! session_id() )
			session_start();
		// Helper::debug( session_id() );
	}


	/**
	 * We register the libraries necessary for
	 * the correct operation of the shortcodes.
	 *
	 * Регистрируем библиотеки необходимые для
	 * корректной работы шорткодов.
	 *
	 * @return void.
	 *
	 * @since 0.0.1
	 * @author Ravil.
	 */
	public function register_shortcodes_vendors() {
		$assets = [
			'css' => [
				'bootstrap' => [
					'id'   => 'briz-bootstrap-css',
					'src'  => PLUGIN_URL . 'assets/vendors/bootstrap/css/bootstrap.min.css',
					'deps' => [],
					'ver'  => '3.3.5'
				],

				'mfp' => [
					'id'   => 'briz-magnific-popup-css',
					'src'  => PLUGIN_URL . 'assets/vendors/magnific-popup/magnific-popup.min.css',
					'deps' => [],
					'ver'  => '1.1.0'
				],

				'fontawesome' => [
					'id'   => 'briz-fontawesome-css',
					'src'  => PLUGIN_URL . 'assets/vendors/font-awesome-4.7.0/css/font-awesome.min.css',
					'deps' => [],
					'ver'  => '4.7.0'
				],
			],

			'js' => [
				'bootstrap' => [
					'id'   => 'briz-bootstrap-js',
					'src'  => PLUGIN_URL . 'assets/vendors/bootstrap/js/bootstrap.min.js',
					'deps' => [ 'jquery' ],
					'ver'  => '3.3.5',
					'in_footer' => true
				],

				'mfp' => [
					'id'   => 'briz-magnific-popup-js',
					'src'  => PLUGIN_URL . 'assets/vendors/magnific-popup/jquery.magnific-popup.min.js',
					'deps' => [ 'jquery' ],
					'ver'  => '1.1.0',
					'in_footer' => true
				],

				'isotop' => [
					'id'   => 'briz-isotop-js',
					'src'  => PLUGIN_URL . 'assets/vendors/isotope/isotope.pkgd.min.js',
					'deps' => [ 'jquery' ],
					'ver'  => '3.0.1',
					'in_footer' => true
				],

				'masonry' => [
					'id'   => 'briz-masonry-js',
					'src'  => PLUGIN_URL . 'assets/vendors/masonry/masonry.pkgd.min.js',
					'deps' => [ 'jquery' ],
					'ver'  => '3.3.2',
					'in_footer' => true
				],

				'imagesloaded' => [
					'id'   => 'briz-imagesloaded-js',
					'src'  => PLUGIN_URL . 'assets/vendors/imagesloaded/imagesloaded.pkgd.min.js',
					'deps' => [ 'jquery' ],
					'ver'  => '3.3.2',
					'in_footer' => true
				],

				'animatenumber' => [
					'id'   => 'briz-animatenumber-js',
					'src'  => PLUGIN_URL . 'assets/vendors/animateNumber/jquery.animateNumber.js',
					'deps' => [ 'jquery' ],
					'ver'  => '0.0.12',
					'in_footer' => true
				],

				'wow' => [
					'id'   => 'briz-wow-js',
					'src'  => PLUGIN_URL . 'assets/vendors/wow/wow.min.js',
					'deps' => [],
					'ver'  => '1.1.2',
					'in_footer' => true
				],

				'parallax' => [
					'id'   => 'briz-parallax-js',
					'src'  => PLUGIN_URL . 'assets/vendors/parallax/parallax.min.js',
					'deps' => [ 'jquery' ],
					'ver'  => '1.4.2',
					'in_footer' => true
				],
			]
		];

		$assets = apply_filters( "briz_shortcodes_vendors", $assets );
		self::join_assets( $assets );
	}


	/**
	 * Registration or enqueue of styles and scripts.
	 *
	 * Регистрация или подключение стилей и скриптов.
	 *
	 * @param Array $assets {
	 *  @type Array $css {
	 *   @type String $id   - id стилей.
	 *   @type String $src  - URL файла стилей.
	 *   @type Array $deps  - другие стили от которых зависит.
	 *                        правильная работа текущего файла стилей.
	 *   @type String $ver  - версия регистрируемого файла стилей( не обязательно ).
	 *  }
	 *  @type Array $js {
	 *   @type String $id   - id скрипта.
	 *   @type String $src  - URL файла.
	 *   @type Array $deps  - другие скрипты от которых зависит.
	 *                        правильная работа текущего скрипта.
	 *   @type String $ver  - версия регистрируемого скрипта( не обязательно ).
	 *   @type Boolean $in_footer - где выводить скрипт: в head или footer.
	 *  }
	 * }
	 *
	 * @param String $register - определяет какое действие совершать,
	 *                           регистрировать или подключать 'CSS' и 'JS'.
	 *                           Available: 'true' or 'false'
	 *                           Default: 'true'
	 *
	 * @see Briz_Shortcodes::merge_shortcode_assets()
	 *  @link ~/main_class.php
	 *
	 * @see Briz_Tax_Shortcode::join_assets()
	 *  @link ~/inc/shortcode_briz_tax.php
	 *
	 * @return void.
	 *
	 * @since 0.0.1
	 * @author Ravil.
	 */
	public static function join_assets( $assets, $register = true ) {
		foreach ( $assets as $type => $data ) {
			foreach ( $data as $item ) {
				extract( $item );

				if ( 'css' == $type ) {
					if ( $register ) {
						if ( ! wp_style_is( $id, 'registered' ) )
							wp_register_style( $id, $src, $deps, $ver );
					} else {
						if ( ! wp_style_is( $id, 'enqueued' ) )
							wp_enqueue_style( $id, $src, $deps, $ver );
					}
				} else {
					if ( $register ) {
						if ( ! wp_script_is( $id, 'registered' ) )
							wp_register_script( $id, $src, $deps, $ver, $in_footer );
					} else {
						if ( ! wp_script_is( $id, 'enqueued' ) )
							wp_enqueue_script( $id, $src, $deps, $ver, $in_footer );
					}
				}
			}
		}
	}


	/**
	 * Adding shortcode parameters to the session.
	 *
	 * Добавление параметров шорткода в сессию.
	 *
	 * @param String $shortcode_id - id шорткода.
	 * @param Array $atts - параметры шорткода.
	 *
	 * @see Briz_Tax_Shortcode::shortcode_briz_tax()
	 *  @link ~/inc/shortcode_briz_tax.php
	 *
	 * @see Briz_Tax_Shortcode::set_post_offset()
	 *  @link ~/inc/shortcode_briz_tax.php
	 *
	 * @return void.
	 *
	 * @since 0.0.1
	 * @author Ravil.
	 */
	public static function add_to_session( $shortcode_id, $atts ) {
		$_SESSION[ $shortcode_id ] = json_encode( $atts );
	}


	/**
	 * Debug.
	 *
	 * @param Mixed $data - отладочная информация которую надо вывести на экран.
	 * @param String $pl - значение свойства "padding-left".
	 * @param String $text - префикс.
	 *
	 * @return void.
	 *
	 * @since 0.0.1
	 * @author Ravil.
	 */
	public static function debug( $data, $pl = '0', $text = '' ) {
		echo '<pre style="padding-left:' . $pl . ';">';
		if ( $text )
			echo $text . '<br />';
		print_r( $data );
		echo '</pre>';
	}


	/**
	* Debug Only.
	*/
	public static function get_registered_styles () {
		$registered_styles = array_keys( $GLOBALS['wp_styles']->registered );
		natcasesort( $registered_styles );
		self::debug( $registered_styles );
	}


	/**
	* Debug Only.
	*/
	public static function get_registered_scripts () {
		$registered_scripts = array_keys( $GLOBALS['wp_scripts']->registered );
		natcasesort( $registered_scripts );
		self::debug( $registered_scripts );
	}
}

new Helper();
