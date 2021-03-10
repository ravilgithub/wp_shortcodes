<?php
namespace Bri_Shortcodes;

/**
 * Класс реализует шорткод "bri_message",
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
 *   @class            - классы ( дополнительные )
 *   @type             - тип оформления ( 1 - default | 2 )
 *                     - 1 - link текст
 *                     - 2 - link ввиде кнопки
 *   @link             - ссылка ( http | https ) на страницу или файл.
 *   @link_text        - текст ссылки
 *   @link_color       - CSS цвет ссылки
 *   @link_back        - CSS цвет фона ссылки если @type == 2
 *   @border           - CSS цвет рамки элемента и кнопки если @type == 2
 *   @border_width     - CSS ширина рамки элемента и кнопки если @type == 2
 *   @border_top       - CSS цвет верхней рамки элемента
 *   @border_top_width - CSS ширина верхней рамки элемента
 *   @back             - CSS цвет фона элемента
 *   @text_color       - CSS цвет текста по умолчанию для всего блока
 *   @text_size        - CSS размер шрифта и зависимые от него внутренние отступы.
 *   @icon_name        - часть класса иконки ( полный класс .fa.fa-{$icon_name} )
 *   @target           - как открывать ссылку ( _self | _parent | _blank )
 *   @rel              - отношения между ссылками
 *                       ( https://developer.mozilla.org/ru/docs/Web/HT ML/Element )
 *   @download         - для скачивания файла ( 0 | 1 )
 *   @onklick          - обработчик события. onclick='..."string"...'
 * }
 *
 * Пример:
 * [bri_message
 *  type="2"
 *  link="https"
 *  link_text="yandex"
 * ]
 *  Message text.
 * [/bri_message]
 *
 * @since 0.0.1
 * @author Ravil
 */
class Bri_Message_Shortcode extends Bri_Shortcodes {
	public $name   = 'bri_message';
	public $assets = [
		'css' => [
			'bri_message' => [
				'deps' => [
					'bri-fontawesome-css',
					// 'bri-bootstrap-css'
				],
				'ver'  => '1.0.0'
			],
		],

		'js' => []
	];
	public $inline_styles = [];
	public static $n      = 1;
	public $default_atts  = [
		'class'            => '',
		'type'             => 1,
		'link'             => '',
		'link_text'        => '',
		'link_color'       => '#333',
		'link_back'        => '#fff',
		'border'           => '#eee',
		'border_width'     => '1px',
		'border_top'       => '#c09',
		'border_top_width' => '3px',
		'back'             => '#fafafa',
		'text_color'       => '#999',
		'text_size'        => '1em',
		'icon_name'        => 'exclamation-circle',
		'target'           => '',
		'rel'              => '',
		'download'         => 0,
		'onclick'          => '',
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
	 * Функция обработчик шорткода "bri_message".
	 *
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $content - контент переданный между парными тегами шорткода.
	 * @param String $tag     - имя шорткода указанный первым
	 *                          параметром в фукции "add_shortcode".
	 *
	 * @return String HTML    - разметка сформированного шорткода.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function shortcode_bri_message( $atts, $content, $tag ) {
		$default_class = $this->get_full_name();
		$id            = $default_class . '_' . self::$n++;
		$target        = '';
		$rel           = '';
		$download      = '';
		$onclick       = '';

		$content = wp_kses( $content, 'post' );

		if ( empty( $content ) )
			return false;

		$atts = $this->prepare_atts( $atts );

		$atts[ 'class' ] .= ( ! empty( $atts[ 'class' ] ) ) ? " $default_class" : $default_class;

		if ( ( int ) $atts[ 'type' ] ) {
			$atts[ 'class' ] .= " {$default_class}_type_{$atts[ 'type' ]}";
		}

		if ( ! empty( $atts[ 'link' ] ) && ! empty( $atts[ 'link_text' ] ) ) {
			$atts[ 'link' ] = esc_url( $atts[ 'link' ] );
			if ( ! empty( $atts[ 'link_color' ] ) ) {
				$this->add_inline_styles( 'a', 'color', $atts[ 'link_color' ] );
			}

			if ( ! empty( $atts[ 'border_top' ] ) ) {
				$this->add_inline_styles( 'a:hover', 'color', $atts[ 'border_top' ] );
			}

			if ( 2 === ( int ) $atts[ 'type' ] ) {
				if ( ! empty( $atts[ 'link_back' ] ) ) {
					$this->add_inline_styles( 'a', 'background-color', $atts[ 'link_back' ] );
				}

				if ( ! empty( $atts[ 'border_width' ] ) ) {
					$this->add_inline_styles( 'a', 'border-width', $atts[ 'border_width' ] );

					if ( ! empty( $atts[ 'border' ] ) ) {
						$this->add_inline_styles( 'a', 'border-color', $atts[ 'border' ] );
					}

					if ( ! empty( $atts[ 'border_top' ] ) ) {
						$this->add_inline_styles( 'a:hover', 'border-color', $atts[ 'border_top' ] );
					}
				}
			}
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

		if ( ! empty( $atts[ 'border_width' ] ) ) {
			$this->add_inline_styles( '.bri-woocommerce-info-inner', 'border-width', $atts[ 'border_width' ] );
			if ( ! empty( $atts[ 'border' ] ) ) {
				$this->add_inline_styles( '.bri-woocommerce-info-inner', 'border-color', $atts[ 'border' ] );
			}

			if ( ! empty( $atts[ 'border_top' ] ) ) {
				$this->add_inline_styles( '.bri-woocommerce-info-inner', 'border-top-color', $atts[ 'border_top' ] );
			}

			if ( ! empty( $atts[ 'border_top_width' ] ) ) {
				$this->add_inline_styles( '.bri-woocommerce-info-inner', 'border-top-width', $atts[ 'border_top_width' ] );
			}
		}

		if ( ! empty( $atts[ 'border_top' ] ) ) {
			$this->add_inline_styles( 'i', 'color', $atts[ 'border_top' ] );
		}

		if ( ! empty( $atts[ 'back' ] ) ) {
			$this->add_inline_styles( '.bri-woocommerce-info-inner', 'background-color', $atts[ 'back' ] );
		}

		if ( ! empty( $atts[ 'text_color' ] ) ) {
			$this->add_inline_styles( '.bri-woocommerce-info-inner', 'color', $atts[ 'text_color' ] );
		}

		if ( ! empty( $atts[ 'text_size' ] ) ) {
			$this->add_inline_styles( '.bri-woocommerce-info-inner', 'font-size', $atts[ 'text_size' ] );
		}

		$this->add_shortcode_style( $id, $atts );

		return $this->display_message( $content, $atts, $id, $rel, $target, $download, $onclick );
	}


	/**
	 * Display Message.
	 *
	 * Формирует разметку элемента.
	 *
	 * @param Array  $content  - текст элемента.
	 * @param Array  $atts     - атрибуты переданные в шорткод.
	 * @param String $id       - атрибут элемента.
	 * @param String $rel      - атрибут "rel".
	 * @param String $target   - атрибут "target".
	 * @param String $download - атрибут "download".
	 * @param String $onclick  - атрибут "onclick" ( в значении не допустимы символы "[" и "]" ).
	 *
	 * @return String HTML     - разметка элемента.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function display_message( $content, $atts, $id, $rel, $target, $download, $onclick ) {

		$lang_domain = apply_filters( 'bri_shortcode_lang_domain', $this->lang_domain );

		ob_start();
?>
		<div id="<?php echo $id ?>" class="<?php echo $atts[ 'class' ]?>" role="alert">
			<span class="bri-woocommerce-info-inner">

<?php if ( ! empty( $atts[ 'icon_name' ] ) ) : ?>
				<i class="fa fa-<?php echo $atts[ 'icon_name' ] ?>" aria-hidden="true"></i>
<?php endif ?>

<?php if ( 2 !== ( int ) $atts[ 'type' ] ) : ?>
				<?php _e( $content, $lang_domain ) ?>
<?php endif ?>

<?php if ( ! empty( $atts[ 'link' ] ) ) : ?>
				<a href="<?php echo $atts[ 'link' ] ?>" <?php echo $rel, $target, $onclick, $download ?>>

					<?php _e( $atts[ 'link_text' ], $lang_domain ) ?>

				</a>
<?php endif ?>

<?php if ( 2 === ( int ) $atts[ 'type' ] ) : ?>
				<?php _e( $content, $lang_domain ) ?>
<?php endif ?>

			</span>
		</div>

<?php
		return trim( ob_get_clean() );
	}
}
