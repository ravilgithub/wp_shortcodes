<?php
/**
 * Класс реализует шорткод "bri_highlight",
 * который позволяет выделить к примеру слово параграфа.
 *
 * Доступные атрибуты:
 * @class - классы
 * @color - цвет шрифта
 * @back  - цвет фона
 * 
 * Пример формирования:
 * Enim [bri_highlight color="#8f8" back="#404040"]necessitatibus[/bri_highlight], explicabo...
 */

namespace Bri_Shortcodes;

class Bri_Highlight_Shortcode extends Bri_Shortcodes {
	public $name   = 'bri_highlight';
	public $assets = [
    'css' => [
      'bri_highlight' => [
        'deps' => [],
        'ver'  => '1.0.0'
      ],
    ]
  ];
	public $inline_styles = array();
	public static $n      = 1;
	public $default_atts  = array(
		'class' => '',
		'color' => '',
		'back'  => ''
	);


	/**
	 * Call parent __construct function.
	 *
	 * Вызываем родительскую функцию __construct.
	 *
	 * @param Object $obj - может принять другой объект в котором будет обрабатываться шорткод.
	 *
	 * @return void.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function __construct( $obj = '' ) {
		parent::__construct( $obj );
	}


	/**
	 * List shortcode callback.
	 *
	 * Функция обработчик шорткода "bri_highlight".
	 *
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $content - контент переданный между парными тегами шорткода.
	 * @param String $tag     - имя шорткода указанный первым параметром в фукции "add_shortcode".
	 *
	 * @return String HTML    - разметка сформированного шорткода.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function shortcode_bri_highlight( $atts, $content, $tag ) {
		$default_class = $this->get_full_name();
		$id            = $default_class . '_' . self::$n++;

		$content = wp_kses( $content, 'post' );
		
		if ( empty( $content ) )
			return false;

		$atts = $this->prepare_atts( $atts );
		
		$atts[ 'class' ] .= ( ! empty( $atts[ 'class' ] ) ) ? " $default_class" : $default_class;

		if ( ! empty( $atts[ 'color' ] ) ) {
			$this->add_inline_styles( '', 'color', $atts[ 'color' ] );
		}

		if ( ! empty( $atts[ 'back' ] ) ) {
			$this->add_inline_styles( '', 'background-color', $atts[ 'back' ] );
		}

		$this->add_shortcode_style( $id, $atts );
			
		return $this->display_highlight( $content, $atts, $id );
	}


	/**
	 * Display accented word.
	 *
	 * Формирует разметку акцентированного слова.
	 *
	 * @param Array  $content - акцентируемое слово.
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $id      - атрибут элемента.
	 *
	 * @return String HTML    - разметка акцентированного слова.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function display_highlight( $content, $atts, $id ) {

		$lang_domain = apply_filters( 'bri_shortcode_lang_domain', $this->lang_domain );
		
		ob_start();
?>
		<span id="<?php echo $id ?>" class="<?php echo $atts[ 'class' ] ?>"><?php _e( $content, $lang_domain ) ?></span>
<?php
		return trim( ob_get_clean() );
	}
}
