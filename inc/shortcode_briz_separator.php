<?php
namespace Briz_Shortcodes\inc;
use Briz_Shortcodes\Shortcodes;
use Briz_Shortcodes\common\Helper;

/**
 * Класс реализует шорткод "briz_saparator",
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
 *   @class         - дополнительные классы.
 *   @width         - ширина элемента.
 *   @margin_top    - верхний внешний отступ элемента.
 *   @margin_bottom - нижний внешний отступ в элемента.
 *   @border_width  - CSS ширина рамки.
 *   @border_style  - CSS стиль рамки.
 *   @border_color  - CSS цвет рамки.
 *   @text_color    - CSS цвет текста при наведении на блок.
 *   @text_size     - CSS размер шрифта.
 *   @position      - обтeкание ( left | center | right )
 *   @back          - CSS цвет фона элемента.
 *   @diamond       - Использовать ли декорацию вместо контента ( 0 | 1 ).
 * }
 * 
 * Пример:
 * [briz_separator
 *  position="center"
 *  border_color="#f00"
 *  text_color="#00f"
 *  text_size="2em"
 * ]
 *  Content
 * [/briz_separator]
 *
 * @since 0.0.1
 * @author Ravil
 */
class Briz_Separator_Shortcode extends Shortcodes {
	public $name   = 'briz_separator';
	public $assets = [
		'css' => [
			'briz_separator' => [
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
		'width'         => '100%',
		'margin_top'    => '20px',
		'margin_bottom' => '20px',
		'border_width'  => '1px',
		'border_style'  => 'solid',
		'border_color'  => '#eee',
		'text_color'    => '#90c948',
		'text_size'     => '20px',
		'back'          => '#fff',
		'position'      => 'left',
		'diamond'       => 0,
	];


	/**
	 * Call parent __construct function.
	 *
	 * Вызываем родительскую функцию __construct.
	 *
	 * @param Object $obj - может принять другой объект в котором будет обрабатываться шорткод.
	 *
	 * @return void.
	 * @since  0.0.1
	 * @author Ravil
	 */
	public function __construct( $obj = '' ) {
		parent::__construct( $obj );
	}


	/**
	 * List shortcode callback.
	 *
	 * Функция обработчик шорткода "briz_separator".
	 *
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $content - контент переданный между парными тегами шорткода.
	 * @param String $tag     - имя шорткода указанный первым параметром в фукции "add_shortcode".
	 *
	 * @return String HTML    - разметка сформированного шорткода.
	 * @since  0.0.1
	 * @author Ravil
	 */
	public function shortcode_briz_separator( $atts, $content, $tag ) {
		$atts = $this->prepare_atts( $atts );

		if ( absint( $atts[ 'disabled' ] ) )
			return false;

		$default_class = $this->get_full_name();
		$id            = $default_class . '_' . self::$n++;
		$content       = wp_kses( $content, 'post' );

		$atts[ 'class' ] .= ( ! empty( $atts[ 'class' ] ) ) ? " $default_class" : $default_class;

		if ( ! empty( $atts[ 'width' ] ) ) {
			// { width }
			$this->add_inline_styles( '', 'width', $atts[ 'width' ] );
		}

		if ( ! empty( $atts[ 'margin_top' ] ) ) {
			// { margin-top }
			$this->add_inline_styles( '', 'margin-top', $atts[ 'margin_top' ] );
		}

		if ( ! empty( $atts[ 'margin_bottom' ] ) ) {
			// { margin-bottom }
			$this->add_inline_styles( '', 'margin-bottom', $atts[ 'margin_bottom' ] );
		}

		if ( ! empty( $atts[ 'border_width' ] ) ) {

			// { border-top-width }
			$this->add_inline_styles( '', 'border-top-width', $atts[ 'border_width' ] );

			if ( ! empty( $atts[ 'border_style' ] ) ) {
				// { border-top-style }
				$this->add_inline_styles( '', 'border-top-style', $atts[ 'border_style' ] );
			}

			if ( ! empty( $atts[ 'border_color' ] ) ) {
				// { border-top-color }
				$this->add_inline_styles( '', 'border-top-color', $atts[ 'border_color' ] );
			}

			if ( $atts[ 'diamond' ] ) {
				// .shortcode_briz_separator_content_wrap .shortcode_briz_separator_diamond { border-width }
				$this->add_inline_styles( '.shortcode_briz_separator_content_wrap .shortcode_briz_separator_diamond', 'border-width', $atts[ 'border_width' ] );

				if ( ! empty( $atts[ 'border_style' ] ) ) {
					// .shortcode_briz_separator_content_wrap .shortcode_briz_separator_diamond { border-style }
					$this->add_inline_styles( '.shortcode_briz_separator_content_wrap .shortcode_briz_separator_diamond', 'border-style', $atts[ 'border_style' ] );
				}

				if ( ! empty( $atts[ 'border_color' ] ) ) {
					// .shortcode_briz_separator_content_wrap .shortcode_briz_separator_diamond { border-color }
					$this->add_inline_styles( '.shortcode_briz_separator_content_wrap .shortcode_briz_separator_diamond', 'border-color', $atts[ 'border_color' ] );
				}
			}
		}

		if ( ! empty( $atts[ 'text_color' ] ) ) {
			// { color }
			$this->add_inline_styles( '', 'color', $atts[ 'text_color' ] );
		}

		if ( ! empty( $atts[ 'text_size' ] ) ) {
			// { font-size }
			$this->add_inline_styles( '', 'font-size', $atts[ 'text_size' ] );

			// { line-height }
			$this->add_inline_styles( '', 'line-height', $atts[ 'text_size' ] );

			if ( $atts[ 'diamond' ] ) {
				// .shortcode_briz_separator_content_wrap .shortcode_briz_separator_diamond { width }
				$this->add_inline_styles( '.shortcode_briz_separator_content_wrap .shortcode_briz_separator_diamond', 'width', $atts[ 'text_size' ] );

				// .shortcode_briz_separator_content_wrap .shortcode_briz_separator_diamond { height }
				$this->add_inline_styles( '.shortcode_briz_separator_content_wrap .shortcode_briz_separator_diamond', 'height', $atts[ 'text_size' ] );
			}
		}

		if ( ! empty( $atts[ 'text_size' ] ) && ! empty( $atts[ 'border_width' ] ) ) {
			$fz = $atts[ 'text_size' ];
			$bdw = $atts[ 'border_width' ];
			$top = "calc( $fz / -2 - $bdw / 2 )";

			// .shortcode_briz_separator_content_wrap { top }
			$this->add_inline_styles( '.shortcode_briz_separator_content_wrap', 'top', $top );
		}

		if ( ! empty( $atts[ 'back' ] ) ) {
			// .shortcode_briz_separator_content_wrap { background-color }
			$this->add_inline_styles( '.shortcode_briz_separator_content_wrap', 'background-color', $atts[ 'back' ] );
		}

		if ( ! empty( $atts[ 'position' ] ) ) {
			$atts[ 'class' ] .= " {$default_class}_{$atts[ 'position' ]}";
		}

		$this->add_shortcode_style( $id, $atts );

		return $this->display_image( $content, $atts, $id );
	}


	/**
	 * Display Blockquote.
	 *
	 * Формирует разметку элемента.
	 *
	 * @param String $content - текст элемента.
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $id      - атрибут элемента.
	 *
	 * @return String HTML    - разметка элемента.
	 * @since  0.0.1
	 * @author Ravil
	 */
	public function display_image( $content, $atts, $id ) {
		ob_start();
?>
		<div id="<?php echo $id ?>" class="<?php echo $atts[ 'class' ] ?>">
			<?php if ( $atts[ 'diamond' ] ) : ?>
				<div class="shortcode_briz_separator_content_wrap">
					<div class="shortcode_briz_separator_diamond"></div>
				</div>
			<?php elseif ( ! empty( $content ) ) : ?>
				<div class="shortcode_briz_separator_content_wrap">
					<?php _e( $content, $this->lang_domain ) ?>
				</div>
			<?php endif; ?>
		</div>
<?php
		return trim( ob_get_clean() );
	}
}
