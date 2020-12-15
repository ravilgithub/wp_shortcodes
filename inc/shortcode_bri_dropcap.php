<?php
/**
 * Класс реализует шорткод "bri_dropcap",
 * который позволяет выделить к примеру первый символ параграфа.
 *
 * Доступные атрибуты:
 * @class  - классы
 * @size   - размер символа ( 1, 2, 3 )
 * @circle - скруглённые края блока ( 0 | 1 )
 * @border - цвет рамки
 * @back   - цвет фона
 * @color  - цвет символа
 * 
 * Пример формирования :
 * [bri_dropcap size="2" circle="1" color="#fff" border="" back="#90c948"]L[/bri_dropcap]orem ipsum dolor sit amet.
 */

namespace Bri_Shortcodes;

class Bri_Dropcap_Shortcode extends Bri_Shortcodes {
	public $name   = 'bri_dropcap';
	public $assets = [
    'css' => [
      'bri_dropcap' => [
        'deps' => [],
        'ver'  => '1.0.0'
      ],
    ]
  ];
	public $inline_styles = array();
	public static $n      = 1;
	public $default_atts  = array(
		'class'  => '',
		'size'   => 1,
		'circle' => 0,
		'border' => '#ccc',
		'back'   => '#fafafa',
		'color'  => '#333'
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
	 * Dropcap shortcode callback.
	 *
	 * Функция обработчик шорткода "bri_dropcap".
	 *
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $content - контент переданный между парными тегами шорткода.
	 * @param String $tag     - имя шорткода указанный первым параметром в фукции "add_shortcode".
	 *
	 * @return String HTML    - разметка сформированного шорткода.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function shortcode_bri_dropcap( $atts, $content, $tag ) {
		$default_class = $this->get_full_name();
		$id            = $default_class . '_' . self::$n++;

		$content = wp_kses( $content, 'post' );
		
		if ( empty( $content ) )
			return false;

		$atts = $this->prepare_atts( $atts );

		$atts[ 'class' ] .= ( ! empty( $atts[ 'class' ] ) ? " $default_class" : $default_class );

		$size = abs( ( int ) $atts[ 'size' ] );
		
		if ( $size ) {
			if ( $size > 3 )
				$size = 3;
		} else {
			$size = 1;
		}

		$atts[ 'class' ] .= " {$default_class}_size_{$size}";

		if ( ( int ) $atts[ 'circle' ] ) {
			$atts[ 'class' ] .= " {$default_class}_circle";
		}

		if ( ! empty( $atts[ 'color' ] ) ) {
			$this->add_inline_styles( '', 'color', $atts[ 'color' ] );
		}

		if ( ! empty( $atts[ 'back' ] ) ) {
			$this->add_inline_styles( '', 'background-color', $atts[ 'back' ] );
			$atts[ 'class' ] .= " {$default_class}_back";
		}

		if ( ! empty( $atts[ 'border' ] ) ) {
			$this->add_inline_styles( '', 'border-color', $atts[ 'border' ] );
			$atts[ 'class' ] .= " {$default_class}_border";
		}

		$this->add_shortcode_style( $id, $atts );
			
		return $this->display_dropcap( $content, $atts, $id );
	}


	/**
	 * Display accented first character.
	 *
	 * Формирует разметку акцентирования первого символа.
	 *
	 * @param Array  $content  - акцентируемый символ.
	 * @param Array  $atts     - атрибуты переданные в шорткод.
	 * @param String $id       - атрибут элемента.
	 *
	 * @return String HTML     - разметка акцентированого первого символа.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function display_dropcap( $content, $atts, $id ) {
		
		$lang_domain = apply_filters( 'bri_shortcode_lang_domain', $this->lang_domain );

		ob_start();
?>
		<span id="<?php echo $id ?>" class="<?php echo $atts[ 'class' ] ?>"><?php _e( $content, $lang_domain ) ?></span>
<?php		
		return trim( ob_get_clean() );
	}
}
