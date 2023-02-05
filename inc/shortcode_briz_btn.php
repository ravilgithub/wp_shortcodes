<?php
namespace Briz_Shortcodes\inc;
use Briz_Shortcodes\Shortcodes;
use Briz_Shortcodes\common\Helper;

/**
 * Класс реализует шорткод "briz_btn",
 * который позволяет формировать
 * HTML разметку элемента.
 *
 * @property String $name - Имя шорткода.
 * @property Array $assets - {
 *  ... Array $deps - Массив идентификаторов других стилей/скриптов,
 *                    от которых зависит подключаемый файл стилей/скрипт.
 *                    Указанные тут стили, будут подключены до текущего.
 *  ... String $ver - Строка определяющая версию стилей/скрипта.
 * }
 * @property Array $inline_styles - инлайн стили образованные из атрибутов шорткода.
 * @property Integer $n - порядковый номер шордкода.
 * @property Array $default_atts {
 *  Доступные атрибуты:
 *   @disabled      - состояние шорткода( включен(1)/выключен(0) )
 *   @class         - классы ( дополнительные - left, right )
 *   @btn           - 0 - <a> | 1 - <button>
 *   @type          - тип оформления ( 1 | 2 )
 *   @link          - ссылка ( http | https ) на страницу или файл.
 *   @width         - минимальная ширина элемента.
 *   @border        - CSS цвет рамки
 *   @border_width  - CSS ширина рамки
 *   @back          - CSS цвет фона
 *   @text_color    - CSS цвет текста по умолчанию для всего блока
 *   @text_size     - CSS размер шрифта и зависимые от него внутренние отступы.
 *   @shadow        - тень ( 0 | 1 )
 *   @rounded       - закругление краёв ( 0 | 1 )
 *   @animation     - анимация при наведении курсора ( fade | slide )
 *   @icon_name     - часть класса иконки ( полный класс .fa.fa-{$icon_name} )
 *   @icon_right    - позиция иконки: 0 - слева | 1 - справа.
 *   @icon_separate - иконка как отдельный элемент ( 0 | 1 )
 *   @position      - обтeкание ( left | right )
 *   @target        - как открывать ссылку ( _self | _parent | _blank )
 *   @rel           - отношения между ссылками ( https://developer.mozilla.org/ru/docs/Web/HTML/Element
 *   @download      - для скачивания файла ( 0 | 1 )
 *   @onklick       - обработчик события. onclick='..."string"...'
 * }
 * 
 * Пример:
 *
 * Download file:
 * [briz_btn
 *  class="custom-class"
 *  type="2"
 *  link="http://wordpress/wpfirst/wp-content/uploads/2017/02/portfolio-13.jpg"
 *  icon_separate="1"
 *  text_size="1.5em"
 *  text_color="#cc5"
 *  border=""
 *  back="#cc5"
 *  icon_name="plus-square-o"
 *  rel="void"
 *  download="1"
 * ]
 *  Download file
 * [/briz_btn]
 *
 * Button type="submit":
 * [briz_btn
 *  width="250px"
 *  rel="void"
 *  target="_blank"
 *  onclick="this.parentNode.submit()"
 * ]
 *  Send
 * [/briz_btn]
 *
 * @since 0.0.1
 * @author Ravil
 */
class Briz_Btn_Shortcode extends Shortcodes {
	public $name   = 'briz_btn';
	public $assets = [
		'css' => [
			'briz_btn' => [
				'deps' => [
					'briz-fontawesome-css'
				],
				'ver'  => '1.0.0'
			],
		],

		'js' => []
	];
	public $inline_styles = [];
	public static $n      = 1;
	public $default_atts  = [
		'disabled'      => 0,
		'class'         => '',
		'btn'           => 0, // <button> - false
		'type'          => 1,
		'link'          => '',
		'width'         => '',
		'border'        => '#eee',
		'border_width'  => '1px',
		'back'          => '#fff',
		'text_color'    => '#333',
		'text_size'     => '1em',
		'shadow'        => 0,
		'rounded'       => 0,
		'animation'     => 'fade',
		'icon_name'     => '',
		'icon_right'    => 0,
		'icon_separate' => 0,
		'position'      => '',
		'target'        => '',
		'rel'           => '',
		'download'      => 0,
		'onclick'       => '',
	];


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
	 * Функция обработчик шорткода "briz_btn".
	 *
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $content - контент переданный между парными тегами шорткода.
	 * @param String $tag     - имя шорткода указанный первым параметром в фукции "add_shortcode".
	 *
	 * @return String HTML    - разметка сформированного шорткода.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function shortcode_briz_btn( $atts, $content, $tag ) {
		$atts = $this->prepare_atts( $atts );

		if ( absint( $atts[ 'disabled' ] ) )
			return false;

		$default_class = $this->get_full_name();
		$id            = $default_class . '_' . self::$n++;
		$target        = '';
		$rel           = '';
		$download      = '';
		$onclick       = '';
		$content       = wp_kses( $content, 'post' );

		if ( empty( $content ) )
			return false;

		$atts[ 'class' ] .= ( ! empty( $atts[ 'class' ] ) ) ? " $default_class" : $default_class;

		if ( ( int ) $atts[ 'type' ] ) {
			$atts[ 'class' ] .= " {$default_class}_type_{$atts[ 'type' ]}";
		}

		if ( ! ( int ) $atts[ 'btn' ] ) {
			if ( ! empty( $atts[ 'link' ] ) ) {
				$atts[ 'link' ] = esc_url( $atts[ 'link' ] ) ? esc_url( $atts[ 'link' ] ) : '#';
			}

			if ( ! empty( $atts[ 'onclick' ] ) ) {
				$onclick = 'onclick="' . $atts[ 'onclick' ] . ';"';
			}

			if ( ! empty( $atts[ 'rel' ] ) ) {
				$rel = 'rel="' . $atts[ 'rel' ] . '"';
			}

			if ( ! empty( $atts[ 'target' ] ) ) {
				$target = 'target="' . $atts[ 'target' ] . '"';
			}

			if ( ! empty( $atts[ 'download' ] ) ) {
				$download = 'download ';
			}
		}

		if ( ! empty( $atts[ 'position' ] ) ) {
			$atts[ 'class' ] .= " {$default_class}_{$atts[ 'position' ]}";
		}

		if ( ! empty( $atts[ 'width' ] ) ) {
			// { min-width } +
			$this->add_inline_styles( '', 'min-width', $atts[ 'width' ] );
		}

		if ( ! empty( $atts[ 'border' ] ) ) {
			// { border-color } +
			$this->add_inline_styles( '', 'border-color', $atts[ 'border' ] );
			$atts[ 'class' ] .= " {$default_class}_border";
			if ( ! empty( $atts[ 'border_width' ] ) ) {
				// { border-width } +
				$this->add_inline_styles( '', 'border-width', $atts[ 'border_width' ] );
			}
		}

		if ( ! empty( $atts[ 'back' ] ) ) {
			// { background-color } +
			$this->add_inline_styles( '', 'background-color', $atts[ 'back' ] );
			$atts[ 'class' ] .= " {$default_class}_back";
		}

		if ( ! empty( $atts[ 'text_color' ] ) ) {
			// { color } +
			$this->add_inline_styles( '', 'color', $atts[ 'text_color' ] );
		}

		if ( ! empty( $atts[ 'text_size' ] ) ) {
			// { font-size } +
			$this->add_inline_styles( '', 'font-size', $atts[ 'text_size' ] );
		}

		if ( ! empty( $atts[ 'animation' ] ) ) {
			$atts[ 'class' ] .= " {$default_class}_{$atts[ 'animation' ]}";
		}

		if ( ( int ) $atts[ 'rounded' ] ) {
			$atts[ 'class' ] .= " {$default_class}_rounded";
		}

		if ( ( int ) $atts[ 'shadow' ] ) {
			$atts[ 'class' ] .= " {$default_class}_shadow";
		}

		if ( ! empty( $atts[ 'icon_name' ] ) ) {
			$atts[ 'class' ] .= " {$default_class}_with_icon";
			if ( ( int ) $atts[ 'icon_right' ] ) {
				$atts[ 'class' ] .= " {$default_class}_with_icon_right";
			}
			if ( ( int ) $atts[ 'icon_separate' ] ) {
				$atts[ 'class' ] .= " {$default_class}_with_icon_separate";
			}
		}

		$this->add_shortcode_style( $id, $atts );

		return $this->display_btn( $content, $atts, $id, $rel, $target, $download, $onclick );
	}


	/**
	 * Display Button.
	 *
	 * Формирует разметку элемента.
	 *
	 * @param Array  $content    - текст элемента.
	 * @param Array  $atts       - атрибуты переданные в шорткод.
	 * @param String $id         - атрибут элемента.
	 * @param String $rel        - атрибут "rel".
	 * @param String $target     - атрибут "target".
	 * @param String $download   - атрибут "download".
	 * @param String $onclick    - атрибут "onclick" ( в значении не допустимы символы "[" и "]" ).
	 *
	 * @return String HTML       - разметка элемента.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function display_btn( $content, $atts, $id, $rel, $target, $download, $onclick ) {
		ob_start();

		if ( ( int ) $atts[ 'btn' ] ) :
?>
			<button id="<?php echo $id ?>" class="<?php echo $atts[ 'class' ] ?>" <?php echo $onclick ?>>

<?php else : ?>

			<a href="<?php echo $atts[ 'link' ] ?>" id="<?php echo $id ?>" class="<?php echo $atts[ 'class' ] ?>" <?php echo $rel, $target, $onclick, $download ?>>

<?php endif; ?>

				<?php if ( ! empty( $atts[ 'icon_name' ] ) ) : ?>
					<span class="shortcode_briz_btn_icon">
						<i class="fa fa-<?php echo $atts[ 'icon_name' ] ?>" aria-hidden="true"></i>
					</span>
				<?php endif; ?>

				<span class="shortcode_briz_btn_label"><?php _e( $content, $this->lang_domain ) ?></span>

<?php if ( ( int ) $atts[ 'btn' ] ) : ?>
			</button>
<?php else : ?>
			</a>
<?php
		endif;

		return trim( ob_get_clean() );
	}
}
