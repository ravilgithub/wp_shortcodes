<?php
namespace Briz_Shortcodes;

/**
 * Класс реализует шорткод "briz_spacer",
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
 *   @class  - дополнительные классы.
 *   @height - высота элемента.
 *   @back   - CSS цвет фона.
 * }
 *
 * Пример:
 * [briz_spacer
 *  height="50px"
 *  back="#add76f"
 * /]
 *
 * [briz_spacer
 *  class="class-name"
 *  height="50px"
 *  back="#add76f"
 * ]
 *  Spacer content
 * [/briz_spacer]
 *
 * @since 0.0.1
 * @author Ravil
 */
class Briz_Spacer_Shortcode extends Shortcodes {
	public $name   = 'briz_spacer';
	public $assets = [
		'css' => [
			'briz_spacer' => [
				'deps' => [],
				'ver'  => '1.0.0'
			],
		],

		'js' => []
	];
	public $inline_styles = [];
	public static $n      = 1;
	public $default_atts  = [
		'class'  => '',
		'height' => '20px',
		'back'   => 'inherit',
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
	 * Функция обработчик шорткода "briz_spacer".
	 *
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $content - контент переданный между парными тегами шорткода.
	 * @param String $tag     - имя шорткода указанный первым параметром в фукции "add_shortcode".
	 *
	 * @return String HTML    - разметка сформированного шорткода.
	 * @since  0.0.1
	 * @author Ravil
	 */
	public function shortcode_briz_spacer( $atts, $content, $tag ) {
		$default_class = $this->get_full_name();
		$id            = $default_class . '_' . self::$n++;

		$content = wp_kses( $content, 'post' );

		$atts = $this->prepare_atts( $atts );

		$atts[ 'class' ] .= ( ! empty( $atts[ 'class' ] ) ) ? " $default_class" : $default_class;

		if ( ! empty( $atts[ 'height' ] ) ) {
			// { height }
			$this->add_inline_styles( '', 'height', $atts[ 'height' ] );
		}

		if ( ! empty( $atts[ 'back' ] ) ) {
			// { background-color }
			$this->add_inline_styles( '', 'background-color', $atts[ 'back' ] );
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

		$lang_domain = apply_filters( 'briz_shortcode_lang_domain', $this->lang_domain );

		ob_start();
?>
		<div id="<?php echo $id ?>" class="<?php echo $atts[ 'class' ] ?>">
<?php if ( ! empty( $content ) ) : ?>
			<span class="shortcode_briz_spacer_content"><?php _e( $content, $lang_domain ) ?></span>
<?php endif; ?>
		</div>
<?php
		return trim( ob_get_clean() );
	}
}
