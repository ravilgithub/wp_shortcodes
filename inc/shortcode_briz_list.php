<?php
namespace Briz_Shortcodes;

/**
 * Класс реализует шорткод "briz_list",
 * который позволяет формировать
 * HTML разметку тегов "UL / OL / DL".
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
 *   @class        - дополнительные классы.
 *   @position     - обтeкание ( left | right )
 *   @cursive      - текст курсивом ( 0 | 1 )
 *   @back         - цвет фона
 *   @border       - цвет рамки
 *   @border_width - ширина рамки
 *   @color        - цвет ссылки при собвтии :hover
 *   @icon_color   - цвет иконки
 *   @number_color - цвет нумерации
 *   @dt_width     - ширина блока "dt"
 * }
 *
 * Пример:
 * [briz_list
 *  back="#dcfba0"
 *  border_width="1px"
 *  border="#000"
 *  number_color="#aaf"
 * ]
 *  <ol>
 *   <li>Velit, odio tenetur.</li>
 *    <li>A magni, ipsum.</li>
 *    <li>Quo, delectus, modi.</li>
 *  </ol>
 * [/briz_list]
 *
 * @since 0.0.1
 * @author Ravil
 */
class Briz_List_Shortcode extends Briz_Shortcodes {
	public $name   = 'briz_list';
	public $assets = [
		'css' => [
			'briz_list' => [
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
		'class'        => '',
		'position'     => '',
		'cursive'      => 0,
		'back'         => '',
		'border'       => '#eee',
		'border_width' => '',
		'color'        => '#90c948', // hover
		'icon_color'   => '',
		'number_color' => '',
		'dt_width'     => '120px',
	];


	/**
	 * Call parent __construct function.
	 *
	 * Вызываем родительскую функцию __construct.
	 *
	 * @param Object $obj - может принять другой объект в
	 *                      котором будет обрабатываться шорткод.
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
	 * Функция обработчик шорткода "briz_list".
	 *
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $content - контент переданный между парными тегами шорткода.
	 * @param String $tag     - имя шорткода указанный первым
	 *                          параметром в фукции "add_shortcode".
	 * @return String HTML    - разметка сформированного шорткода.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function shortcode_briz_list( $atts, $content, $tag ) {
		$default_class = $this->get_full_name();
		$id            = $default_class . '_' . self::$n++;
		$prefix        = '';

		// $content = wp_kses_post( $content );

		if ( empty( $content ) )
			return false;

		$atts = $this->prepare_atts( $atts );

		$atts[ 'class' ] .= ( ! empty( $atts[ 'class' ] ) ? " $default_class" : $default_class );

		if ( ! empty( $atts[ 'position' ] ) ) {
			$atts[ 'class' ] .= " {$default_class}_{$atts[ 'position' ]}";
		}

		if ( ( int ) $atts[ 'cursive' ] ) {
			$atts[ 'class' ] .= " {$default_class}_italic";
		}

		if ( ! empty( $atts[ 'border_width' ] ) ) {
			$this->add_inline_styles( 'li', "border-bottom-width", $atts[ 'border_width' ] );
			$this->add_inline_styles( 'dt', "border-top-width", $atts[ 'border_width' ] );
			$this->add_inline_styles( 'dd', "border-top-width", $atts[ 'border_width' ] );

			$this->add_inline_styles( 'li', "border-bottom-color", $atts[ 'border' ] );
			$this->add_inline_styles( 'dt', "border-top-color", $atts[ 'border' ] );
			$this->add_inline_styles( 'dd', "border-top-color", $atts[ 'border' ] );

			$atts[ 'class' ] .= " {$default_class}_line";
		}

		if ( ! empty( $atts[ 'dt_width' ] ) ) {
			$this->add_inline_styles( 'dt', 'width', $atts[ 'dt_width' ] );
			$this->add_inline_styles( 'dd', 'margin-left', 'calc(' . $atts[ 'dt_width' ] . ' + 15px)' );
		}

		if( ! empty( $atts[ 'color' ] ) ) {
			$this->add_inline_styles( 'a:hover', 'color', $atts[ 'color' ] );
		}

		if ( ! empty( $atts[ 'back' ] ) ) {
			$this->add_inline_styles( 'li', "background-color", $atts[ 'back' ] );
			$this->add_inline_styles( 'dd', "background-color", $atts[ 'back' ] );
			$atts[ 'class' ] .= " {$default_class}_back";
		}

		if ( ! empty( $atts[ 'icon_color' ] ) ) {
			$atts[ 'class' ] .= " {$default_class}_icon";
			$this->add_inline_styles( 'i', 'color', $atts[ 'icon_color' ] );
		} elseif ( ! empty( $atts[ 'number_color' ] ) ) {
			$atts[ 'class' ] .= " {$default_class}_number";
			$this->add_inline_styles( 'i', 'color', $atts[ 'number_color' ] );
		}

		$this->add_shortcode_style( $id, $atts );

		return $this->display_list( $content, $atts, $id );
	}


	/**
	 * Display standart( UL / OL ) list.
	 *
	 * Формирует разметку для списков типа "UL / OL".
	 *
	 * @param Array  $content_items - массив содержимого для каждого из списков.
	 * @param Array  $atts          - атрибуты переданные в шорткод.
	 * @param String $id            - атрибут элемента.
	 *
	 * @return String HTML          - разметка для списков типа "UL / OL".
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function display_list( $content, $atts, $id ) {

		// $lang_domain = apply_filters( 'briz_shortcode_lang_domain', $this->lang_domain );

		ob_start();
?>
		<div id="<?php echo $id ?>" class="<?php echo $atts[ 'class' ] ?>"><?php echo $content ?></div>
<?php
		return trim( ob_get_clean() );
	}
}
