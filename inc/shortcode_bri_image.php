<?php
namespace Bri_Shortcodes;

/**
 * Класс реализует шорткод "bri_image",
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
 *   @class        - дополнительные классы.
 *   @type         - тип оформления ( 1 | 2 )
 *   @img_url      - адрес картинки.
 *                   Ссылку на файл можно найти здесь -
 *                   "медиафайлы -> библиотека -> любая картинка -> изменить -> ссылка на файл".
 *                   Пример - http://wordpress/wpfirst/wp-content/uploads/2019/04/shortcode_bri_tooltip_1.png
 *   @link         - ссылка ( http | https ) на страницу или файл.
 *   @width        - ширина элемента.
 *   @border       - CSS цвет рамки.
 *   @border_width - CSS ширина рамки.
 *   @text_color   - CSS цвет текста при наведении на блок.
 *   @text_size    - CSS размер шрифта.
 *   @position     - обтeкание ( left | right )
 *   @target       - как открывать ссылку ( _self | _parent | _blank )
 *   @rel          - отношения между ссылками ( https://developer.mozilla.org/ru/docs/Web/HTML/Element
 *   @onclick      - обработчик события. onclick='..."string"...'
 * }
 *
 * Пример:
 * [bri_image
 *  img_url="http://wordpress/wpfirst/wp-content/uploads/2019/04/shortcode_bri_tooltip_1.png"
 *  width="250px"
 *  link="http://ya.ru"
 *  border="#d3a"
 *  border_width="15px"
 *  text_color="#fff"
 *  type="1"
 *  position="left"
 *  target="_self"
 *  onclick='console.log("bri_image onclick"); return false'
 * ]
 *  shortcode bri image 1
 * [/bri_image]
 *
 * @since 0.0.1
 * @author Ravil
 */
class Bri_Image_Shortcode extends Bri_Shortcodes {
	public $name   = 'bri_image';
	public $assets = [
		'css' => [
			'bri_image' => [
				'deps' => [
					'bri-magnific-popup-css',
					'bri-fontawesome-css'
				],
				'ver'  => '1.0.0'
			],
		],

		'js' => [
			'bri_image' => [
				'deps' => [
					'jquery',
					'bri-magnific-popup-js'
				],
				'ver' => '1.0.0',
				'in_footer' => true
			]
		]
	];
	public $inline_styles = [];
	public static $n      = 1;
	public $default_atts  = [
		'class'        => '',
		'type'         => 1,
		'img_url'      => '',
		'link'         => '',
		'width'        => '',
		'border'       => '#eee',
		'border_width' => '1px', // 0px что бы убрать рамки, но оставить минимальные отступы в .shortcode_bri_image_label
		'text_color'   => '#90c948',
		'text_size'    => '1em',
		'position'     => '',
		'target'       => '',
		'rel'          => '',
		'onclick'      => '',
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
	 * Функция обработчик шорткода "bri_image".
	 *
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $content - контент переданный между парными тегами шорткода.
	 * @param String $tag     - имя шорткода указанный первым параметром в фукции "add_shortcode".
	 *
	 * @return String HTML    - разметка сформированного шорткода.
	 * @since  0.0.1
	 * @author Ravil
	 */
	public function shortcode_bri_image( $atts, $content, $tag ) {
		$default_class = $this->get_full_name();
		$id            = $default_class . '_' . self::$n++;
		$type          = 0;
		$target        = '';
		$rel           = '';
		$onclick       = '';

		$content = wp_kses( $content, 'post' );

		$atts = $this->prepare_atts( $atts );
		$type = ( int ) $atts[ 'type' ];

		$atts[ 'class' ] .= ( ! empty( $atts[ 'class' ] ) ) ? " $default_class" : $default_class;

		if ( $type ) {
			$atts[ 'class' ] .= " {$default_class}_type_{$type}";
		}

		if ( ! empty( $atts[ 'link' ] ) ) {
			$atts[ 'link' ] = esc_url( $atts[ 'link' ] ) ? esc_url( $atts[ 'link' ] ) : '';
		}

		if ( ! empty( $atts[ 'target' ] ) ) {
			$target = 'target="' . $atts[ 'target' ] . '"';
		}

		if ( ! empty( $atts[ 'rel' ] ) ) {
			$rel = 'rel="' . $atts[ 'rel' ] . '"';
		}

		if ( ! empty( $atts[ 'onclick' ] ) ) {
			$onclick = 'onclick="' . $atts[ 'onclick' ] . ';"';
		}

		if ( ! empty( $atts[ 'width' ] ) ) {
			// .shortcode_bri_image_inner_wrapper { width }
			$this->add_inline_styles( '.shortcode_bri_image_inner_wrapper', 'width', $atts[ 'width' ] );
		}

		if ( ! empty( $atts[ 'border_width' ] ) ) {
			$atts[ 'class' ] .= " {$default_class}_border";

			$matches = array();
			$exp = '/^([0-9]+\.?[0-9]*)([a-z]{2,}|\%)$/i'; // результат от 1px - $matches[ '1px' ][ 1 ][ 'px' ]

			if ( preg_match( $exp, $atts[ 'border_width' ], $matches ) ) {
				/*echo '<pre>';
				print_r( $matches );
				echo '</pre>';*/

				$num = min( 24, max( 12, $matches[ 1 ] ) );
				$label_top_padding = $num . $matches[ 2 ];
				$label_bottom_padding = ( $num - $matches[ 1 ] ) . $matches[ 2 ];

				// .shortcode_bri_image_inner_wrapper .shortcode_bri_image_label { padding-top }
				$this->add_inline_styles( '.shortcode_bri_image_inner_wrapper .shortcode_bri_image_label', 'padding-top', $label_top_padding );

				// .shortcode_bri_image_inner_wrapper .shortcode_bri_image_label { padding-bottom }
				$this->add_inline_styles( '.shortcode_bri_image_inner_wrapper .shortcode_bri_image_label', 'padding-bottom', $label_bottom_padding );
			}

			if ( 1 === $type ) {
				// .shortcode_bri_image_inner_wrapper { border-width }
				$this->add_inline_styles( "&.{$default_class}_border .shortcode_bri_image_inner_wrapper", 'border-width', $atts[ 'border_width' ] );
			}

			if ( 2 === $type ) {
				// .shortcode_bri_image_inner_wrapper { padding }
				$this->add_inline_styles( '.shortcode_bri_image_inner_wrapper', 'padding', $atts[ 'border_width' ] );
			}

			if ( ! empty( $atts[ 'border' ] ) ) {
				// .shortcode_bri_image_inner_wrapper { border-color }
				$this->add_inline_styles( "&.{$default_class}_border .shortcode_bri_image_inner_wrapper", 'border-color', $atts[ 'border' ] );
			}
		}

		if ( ! empty( $atts[ 'border' ] ) ) {
			if ( 1 === $type ) {
				// .shortcode_bri_image_inner_wrapper .shortcode_bri_image_label { background-color }
				$this->add_inline_styles( '.shortcode_bri_image_inner_wrapper .shortcode_bri_image_label', 'background-color', $atts[ 'border' ] );
			}
		}

		if ( ! empty( $atts[ 'text_color' ] ) ) {
			// .shortcode_bri_image_inner_wrapper:hover .shortcode_bri_image_label { color }
			$this->add_inline_styles( '.shortcode_bri_image_inner_wrapper:hover .shortcode_bri_image_label', 'color', $atts[ 'text_color' ] );
		}

		if ( ! empty( $atts[ 'text_size' ] ) ) {
			// .shortcode_bri_image_inner_wrapper .shortcode_bri_image_label:hover { font-size }
			$this->add_inline_styles( '.shortcode_bri_image_inner_wrapper .shortcode_bri_image_label:hover', 'font-size', $atts[ 'text_size' ] );
		}

		if ( ! empty( $atts[ 'position' ] ) ) {
			$atts[ 'class' ] .= " {$default_class}_{$atts[ 'position' ]}";
		}

		$this->add_shortcode_style( $id, $atts );
		$this->add_shortcode_script();

		return $this->display_image( $content, $atts, $id, $rel, $target, $onclick );
	}


	/**
	 * Display Blockquote.
	 *
	 * Формирует разметку элемента.
	 *
	 * @param String $content - текст элемента.
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $id      - атрибут элемента.
	 * @param String $rel     - атрибут "rel".
	 * @param String $target  - атрибут "target".
	 * @param String $onclick - атрибут "onclick" ( в значении не допустимы символы "[" и "]" ).
	 *
	 * @return String HTML    - разметка элемента.
	 * @since  0.0.1
	 * @author Ravil
	 */
	public function display_image( $content, $atts, $id, $rel, $target, $onclick ) {

		$lang_domain = apply_filters( 'bri_shortcode_lang_domain', $this->lang_domain );

		ob_start();
?>
		<figure  id="<?php echo $id ?>" class="<?php echo $atts[ 'class' ] ?>">
			<span class="shortcode_bri_image_inner_wrapper">
				<span class="shortcode_bri_image_image_box">

					<?php if ( wp_http_validate_url( $atts[ 'img_url' ] ) ) : ?>
						<img src="<?php echo esc_url( $atts[ 'img_url' ] ) ?>" alt="ALT" />
					<?php endif; ?>

					<span class="shortcode_bri_image_image_mask"></span>

					<span class="shortcode_bri_image_icons_box">

						<?php if ( wp_http_validate_url( $atts[ 'img_url' ] ) ) : ?>
							<a href="<?php echo esc_url( $atts[ 'img_url' ] ) ?>" class="shortcode_bri_image_mfp_popup_icon">
								<i class="fa fa-search" aria-hidden="true"></i>
							</a>
						<?php endif; ?>

						<?php if ( $atts[ 'link' ] ) : ?>
							<a href="<?php echo $atts[ 'link' ] ?>" class="shortcode_bri_image_link_icon" <?php echo $rel, $target, $onclick ?>>
								<i class="fa fa-link" aria-hidden="true"></i>
							</a>
						<?php endif; ?>

					</span>
				</span>

				<?php if ( ! empty( $content ) ) : ?>
					<figcaption class="shortcode_bri_image_label"><?php _e( $content, $lang_domain ) ?></figcaption>
				<?php endif; ?>

			</span>
		</figure>
<?php
		return trim( ob_get_clean() );
	}
}
