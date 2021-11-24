<?php
namespace Briz_Shortcodes\common;

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
		require_once( PLUGIN_PATH . 'common/inc/assets/vendors.php' );
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
	 * We return the values of HTML attributes for images
	 * of sections or posts in sections.
	 *
	 * Отдаём значения HTML атрибутов для картинок секций или записей в секциях.
	 *
	 * @param Array $opts        - мета поля термина или записи.
	 * @param Boolean $is_term   - указываем для кого формируем атрибуты,
	 *                             по умолчанию для записей.
	 *                             Default: false
	 * @param String $img_key    - id картинки в базе данных.
	 *                             Default: ''
	 * @param String $attach_key - имя мета поля которое отвечает
	 *                             за способ прикрепления картинки.
	 *                             Default: 'bg_attachment'
	 *
	 * @return Array              - значения HTML атрибутов.
	 *
	 * @since 0.0.1
	 * @author Ravil.
	 */
	public static function get_bg_atts( $opts, $is_term = false, $img_key = '', $attach_key = 'bg_attachment' ) {
		$bg = '';
		$attachment = '';
		$parallax_data = '';
		$parallax_img_src = '';
		$img_id = 0;
		$img_url = '';

		if ( is_array( $opts ) ) {
			if ( array_key_exists( $attach_key, $opts ) ) {
				$bg_type = $opts[ $attach_key ];

				if ( 'hidden' != $bg_type ) {
					if (
						$is_term &&
						$img_key &&
						array_key_exists( $img_key, $opts ) &&
						! empty( $opts[ $img_key ] )
					) {
						if ( $img_id = ( int ) $opts[ $img_key ] ) {
							$img_url = wp_get_attachment_image_url( $img_id, 'full' );
						} elseif ( $ids = json_decode( $opts[ $img_key ] ) ) {
							if ( $img_id = ( int ) $ids[ 0 ] ) {
								$img_url = wp_get_attachment_image_url( $img_id, 'full' );
							}
						}
					} elseif (
						array_key_exists( 'post_id', $opts ) &&
						$post_id = ( int ) $opts[ 'post_id' ]
					) {
						$img_url = get_the_post_thumbnail_url( $post_id, 'full' );
					}

					if ( $img_url ) {
						if ( 'fixed' == $bg_type || 'default' == $bg_type ) {
							$bg = 'background-image: url(' . $img_url . ')';
							if ( 'fixed' == $bg_type ) {
								$attachment = 'bg-fixed';
							}
						} else {
							$attachment = 'parallax-window';
							$parallax_data = 'scroll';
							$parallax_img_src = $img_url;
						}
					}
				}
			}
		}

		return [ $bg, $attachment, $parallax_data, $parallax_img_src ];
	}


	/**
	 * Sorting groups of meta fields by the value of the "order"
	 * meta field included in these groups.
	 *
	 * Сортировка групп мета полей по значению мета поля "order",
	 * входящих в эти группы.
	 *
	 * @param Array $arr - Массив групп мета полей.
	 *                     В каждой группе имеется поле "order",
	 *                     по значению которого ранжируется данная группа в массиве $arr.
	 *
	 * @return Array $res - отсортированный исходный массив.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function sort( Array $arr ) {
		$tmp = [];
		$res = [];
		foreach ( $arr as $k => $el ) {
			$tmp[ $k ] = ( int ) $el[ 'order' ];
		}

		uasort( $tmp, function( $a, $b ) {
			if ( $a !== $b )
				return $a - $b;
			return $b;
		} );

		foreach ( $tmp as $k => $el ) {
			$res[ $k ] = $arr[ $k ];
		}

		return $res;
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
