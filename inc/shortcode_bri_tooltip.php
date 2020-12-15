<?php
/**
 * Класс реализует шорткод "bri_tooltip",
 * который позволяет создать всплывающую подсказку.
 *
 * Доступные атрибуты:
 * @class   - классы.
 * @hint    - текст подсказки.
 * @img_url - адрес картинки.
 						  Ссылку на файл можно найти здесь - "медиафайлы -> библиотека -> любая картинка -> изменить -> ссылка на файл".
 						  Пример - http://wordpress/wpfirst/wp-content/uploads/2019/04/shortcode_bri_tooltip_1.png
 * @back    - цвет фона.
 * @color   - цвет текста.
 * 
 * Пример формирования :
 * [bri_tooltip hint="Architecto alias esse sapiente" img_url="http://wordpress/wpfirst/wp-content/uploads/2019/04/shortcode_bri_tooltip_1.png" color="#8f8" back="#404040"]necessitatibus[/bri_tooltip]
 */

namespace Bri_Shortcodes;

class Bri_Tooltip_Shortcode extends Bri_Shortcodes {
	public $name          = 'bri_tooltip';
	public $assets = [
    'css' => [
      'bri_tooltip' => [
        'deps' => [],
        'ver'  => '1.0.0'
      ],
    ]
  ];
	public $inline_styles = array();
	public static $n      = 1;
	public $default_atts  = array(
		'class'   => '',
		'hint'    => '',
		'img_url' => '',
		'back'    => '#393939',
		'color'   => '#fff'
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
	 * Функция обработчик шорткода "bri_tooltip".
	 *
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $content - контент переданный между парными тегами шорткода.
	 * @param String $tag     - имя шорткода указанный первым параметром в фукции "add_shortcode".
	 *
	 * @return String HTML    - разметка сформированной всплывающей подсказки.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function shortcode_bri_tooltip( $atts, $content, $tag ) {
		$default_class = $this->get_full_name();
		$id            = $default_class . '_' . self::$n++;

		$content = wp_kses( $content, 'post' );
		$atts = $this->prepare_atts( $atts );
		
		if ( empty( $content ) || empty( $atts[ 'hint' ] ) )
			return false;

		$atts[ 'class' ] .= ( ! empty( $atts[ 'class' ] ) ) ? " $default_class" : $default_class;

		if ( ! empty( $atts[ 'img_url' ] ) ) {
			$atts[ 'class' ] .= " {$default_class}_img";
		}

		if ( ! empty( $atts[ 'color' ] ) ) {
			$this->add_inline_styles( '.shortcode_bri_tooltip_popup', 'color', $atts[ 'color' ] );
		}

		if ( ! empty( $atts[ 'back' ] ) ) {
			$this->add_inline_styles( '.shortcode_bri_tooltip_popup', 'background-color', $atts[ 'back' ] );
		}

		$this->add_shortcode_style( $id, $atts );
			
		return $this->display_dropcap( $content, $atts, $id );
	}


	/**
	 * Display Tooltip.
	 *
	 * Формирует разметку всплывающей подсказки.
	 *
	 * @param Array  $content - текст/элемент нуждающийся в подсказке.
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $id      - атрибут элемента.
	 *
	 * @return String HTML    - разметка всплывающей подсказки.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function display_dropcap( $content, $atts, $id ) {

		$lang_domain = apply_filters( 'bri_shortcode_lang_domain', $this->lang_domain );
		
		ob_start();
?>
		<span id="<?php echo $id ?>" class="<?php echo $atts[ 'class' ] ?>">
			<span class="shortcode_bri_tooltip_popup">
				<?php if ( wp_http_validate_url( $atts[ 'img_url' ] ) ) : ?>
					<img src="<?php echo esc_url( $atts[ 'img_url' ] ) ?>" alt="ALT" />
				<?php endif; ?>
				<?php _e( $atts[ 'hint' ], $lang_domain ) ?>
			</span>
			<?php _e( $content, $lang_domain ) ?>
		</span>
<?php
		return trim( ob_get_clean() );
	}
}
