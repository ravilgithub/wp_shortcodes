<?php
namespace Briz_Shortcodes;
use Briz_Shortcodes\common\Helper;

/**
 * The class implements the general functionality of shortcodes.
 *
 * Класс реализует общий функционал шорткодов.
 *
 * @property String CSS_PATH          - путь к "css" файлу.
 * @property String JS_PATH           - путь к "js" файлу.
 * @property String lang_domain       - регистрационное "id" файла
 *                                      переводов для всех шорткодов.
 * @property Array special_atts_types - специфические обработчики атрибутов шорткода.
 *
 * @since 0.0.1
 * @author Ravil
 */
abstract class Shortcodes {
	const CSS_PATH             = 'assets/css/';
	const JS_PATH              = 'assets/js/';
	public $lang_domain        = 'briz_shortcodes_l10n';
	public $special_atts_types = array(
		'js' => array(
			'atts_names'  => array( 'onclick' ),
			'esc_handler' => 'esc_js',
		),
	);


	/**
	 * Construct.
	 *
	 * @param Object $obj - может принять другой объект в котором будет обрабатываться шорткод.
	 *
	 * @return void.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function __construct( $obj ) {
		$obj = ! empty( $obj ) ? $obj : $this;
		add_shortcode( $this->name, array( $obj, $this->get_full_name() ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'merge_shortcode_assets' ) );

		$this->set_lang_domain();
	}


	/**
	 * Add the $assets property of each shortcode
	 * if it is not empty with the required parameters.
	 * 
	 * Дополняем свойство $assets каждого шорткода
	 * если он не пуст необходимыми параметрами.
	 * 
	 * @return void.
	 * 
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function merge_shortcode_assets() {
		if ( empty( $this->assets ) )
			return;

		$css = [
			$this->name => [
				'id'  => "{$this->name}-shortcode-css",
				'src' => PLUGIN_URL . self::CSS_PATH . $this->get_full_name() . '.min.css'
			]
		];

		$js = [
			$this->name => [
				'id'  => "{$this->name}-shortcode-js",
				'src' => PLUGIN_URL . self::JS_PATH . $this->get_full_name() . '.js'
			]
		];

		$assets = [];

		if ( ! empty( $this->assets[ 'css' ] ) )
			$assets[ 'css' ] = $css;

		if ( ! empty( $this->assets[ 'js' ] ) )
			$assets[ 'js' ] = $js;

		$assets = array_merge_recursive( $assets, $this->assets );
		$assets = apply_filters( $this->get_full_name() . '_assets', $assets );
		
		// Helper::debug( $assets );

		Helper::join_assets( $assets );
	}


	/**
	 * We connect the previously registered shortcode scripts.
	 * 
	 * Подключаем ранее зарегистрированные скрипты шорткода.
	 * 
	 * @return void.
	 * 
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function add_shortcode_script() {
		wp_enqueue_script( "{$this->name}-shortcode-js" );
	}


	/**
	 * Add Inline CSS.
	 *
	 * Добавляем "inline" в свойство $inline_styles из атрибутов шорткода.
	 *
	 * @param String $selector  - CSS селектор элемента.
	 * @param String $prop_name - имя CSS свойства.
	 * @param String $val       - значение CSS свойства.
	 *
	 * @return viod
	 * @since  0.0.1
	 * @author Ravil
	 */
	public function add_inline_styles( $selector, $prop_name, $val ) {
		if ( ! array_key_exists( $selector, $this->inline_styles ) ) {
			$this->inline_styles[ $selector ] = array( $prop_name => $val );
		} else {
			$this->inline_styles[ $selector ] = array_merge( $this->inline_styles[ $selector ], array( $prop_name => $val ) );
		}
	}


	/**
	 * Return Structured Inline CSS.
	 *
	 * Возвращает структурированные "inline" стили.
	 *
	 * @param String $id            - идентификатор элемента.
	 * @param String $inline_styles - "inline" CSS.
	 *
	 * @return String $custom_css
	 * @since  0.0.1
	 * @author Ravil
	 */
	public function get_inline_styles( $id, $inline_styles ) {
		if ( ! empty( $inline_styles ) ) {

			$custom_css = '';
			foreach ( $inline_styles as $selector => $props ) {
				if ( empty( $props ) ) {
					continue;
				}

				if ( '' === $selector ) {
					$custom_css .= "#{$id} {\n";
				} elseif ( 0 === strpos( $selector, ':' ) ) {
					$custom_css .= "#{$id}{$selector} {\n";
				} elseif ( 0 === strpos( $selector, '&' ) ) {
					$selector = substr( $selector, 1 );
					$custom_css .= "#{$id}{$selector} {\n";
				} else {
					$custom_css .= "#{$id} {$selector} {\n";
				}

				foreach ( $props as $prop => $val ) {
					$custom_css .= " {$prop}: {$val};\n";
				}

				$custom_css .= "}\n";
			}

			/*echo '<pre>';
			echo "{$this->name}-shortcode-css inline styles\n";
			print_r( $inline_styles );
			echo '</pre>';*/

			/*echo '<pre>';
			print_r( $custom_css );
			echo '</pre>';*/

			return $custom_css;
		}
	}


	/**
	 * Add Shortcode CSS ( file ) and Inline CSS if exist.
	 *
	 * Добавляем файл стилей.
	 *
	 * Добавляем "inline" стили если они определены в свойстве $inline_styles.
	 *
	 * @param String $id - идентификатор элемента.
	 *
	 * @return viod
	 * @since  0.0.1
	 * @author Ravil
	 */
	public function add_shortcode_style( $id, $atts ) {
		wp_enqueue_style( "{$this->name}-shortcode-css" );
		$inline_styles = apply_filters( $this->get_full_name() . '_inline_styles', $this->inline_styles, $id, $atts );

		$custom_css = $this->get_inline_styles( $id, $inline_styles );

		if ( ! empty( $custom_css ) ) {
			wp_add_inline_style( "{$this->name}-shortcode-css", $custom_css );
		}

		$this->inline_styles = array();
	}


	/**
	 * Register translation file.
	 *
	 * Регистрация файла перевода.
	 *
	 * @return void
	 * @since  0.0.1
	 * @author Ravil
	 */
	public function set_lang_domain() {
		$flag = load_plugin_textdomain( $this->lang_domain, false, basename( dirname( __DIR__ ) ) . '/lang' );
	}


	/**
	 * Get Shortcode Full Name .
	 *
	 * Возвращает полное имя шорткода.
	 *
	 * @return String - shortcode full name.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	function get_full_name() {
		return 'shortcode_' . $this->name;
	}


	/**
	 * Prepare Attributes.
	 *
	 * Отсечка не допустимых атрибутов. Очистка.
	 *
	 * @param Array $atts - атрибуты переданные в шорткод.
	 *
	 * @return Array      - очищенные атрибуты.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function prepare_atts( $atts ) {
		$prepared = array();
		$special_atts_types = apply_filters( $this->get_full_name() . '_special_atts_types', $this->special_atts_types );
		$default_atts = apply_filters( $this->get_full_name() . '_default_atts', $this->default_atts );

		$atts = shortcode_atts( $default_atts, $atts, $this->name );

		foreach ( $atts as $attr => $val ) {
			foreach ( $special_atts_types as $type => $opts ) {
				if ( in_array( $attr, $opts[ 'atts_names' ] ) ) {
					$esc_handler = $opts[ 'esc_handler' ];
					$prepared[ $attr ] = ( is_callable( $esc_handler ) ) ? $esc_handler( $val ) : "Обработчик - $esc_handler для атрибутов - $type не является функцией !!!";
					continue 2;
				}
			}
			$prepared[ $attr ] = esc_attr( trim( $val ) );
		}

		/*echo '<pre>';
		print_r( $prepared );
		echo '</pre>';*/

		return $prepared;
	}
}
