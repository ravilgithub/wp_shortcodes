<?php
/**
 * Класс реализует шорткод "bri_link",
 * который позволяет формировать
 * HTML разметку элемента.
 *
 * Доступные атрибуты:
 * @class         - дополнительные классы.
 * @type          - тип оформления ( 1 | 9 )
 * @link          - ссылка ( http | https ) на страницу или файл.
 * @width         - минимальная ширина элемента.
 * @border        - CSS цвет рамки
 * @border_width  - CSS ширина рамки
 * @back          - CSS цвет фона
 * @text_color    - CSS цвет текста по умолчанию для всего блока
 * @text_size     - CSS размер шрифта и зависимые от него внутренние отступы.
 * @icon_name     - часть класса иконки ( полный класс .fa.fa-{$icon_name} )
 * @icon_right    - позиция иконки: 0 - слева | 1 - справа.
 * @position      - обтeкание ( left | right )
 * @target        - как открывать ссылку ( _self | _parent | _blank )
 * @rel           - отношения между ссылками ( https://developer.mozilla.org/ru/docs/Web/HTML/Element
 * @download      - для скачивания файла ( 0 | 1 )
 * @onklick       - обработчик события. onclick='..."string"...'
 * 
 * Пример:
 * [bri_link type="1" class="custom-class-1 custom-class-2" position="right" link="http://wordpress/wpfirst/wp-content/uploads/2017/02/portfolio-13.jpg" width="200px" border="#f00" border_width="21px" back="#f5f5f5" text_color="#90c948" text_size="1em" icon_name="angle-right" icon_right="1" target="_blank" rel="void" onclick="this.parentNode.submit()" download="1"]type_1 link[/bri_link]
 */

namespace Bri_Shortcodes;

class Bri_Link_Shortcode extends Bri_Shortcodes {
	public $name   = 'bri_link';
	public $assets = [
    'css' => [
      'bri_link' => [
        'deps' => [],
        'ver'  => '1.0.0'
      ],
    ]
  ];
	public $inline_styles = array();
	public static $n      = 1;
	public $default_atts  = array(
		'class'        => '',
		'type'         => 1,
		'link'         => '',
		'width'        => '',
		'border'       => '#eee',
		'border_width' => '1px',
		'back'         => '#fff',
		'text_color'   => '#333',
		'text_size'    => '1em',
		'icon_name'    => '',
		'icon_right'   => 0,
		'position'     => '',
		'target'       => '',
		'rel'          => '',
		'onclick'      => '',
		'download'     => 0,
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
	 * Функция обработчик шорткода "bri_link".
	 *
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $content - контент переданный между парными тегами шорткода.
	 * @param String $tag     - имя шорткода указанный первым параметром в фукции "add_shortcode".
	 *
	 * @return String HTML    - разметка сформированного шорткода.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function shortcode_bri_link( $atts, $content, $tag ) {
		$default_class = $this->get_full_name();
		$id            = $default_class . '_' . self::$n++;
		$type          = 0;
		$target        = '';
		$rel           = '';
		$onclick       = '';
		$download      = '';

		$content = wp_kses( $content, 'post' );
		
		if ( empty( $content ) )
			return false;

		$atts = $this->prepare_atts( $atts );
		$type = ( int ) $atts[ 'type' ];
		
		$atts[ 'class' ] .= ( ! empty( $atts[ 'class' ] ) ) ? " $default_class" : $default_class;

		if ( $type ) {
			$atts[ 'class' ] .= " {$default_class}_type_{$type}";
		}

		if ( ! empty( $atts[ 'link' ] ) ) {
			$atts[ 'link' ] = esc_url( $atts[ 'link' ] ) ? esc_url( $atts[ 'link' ] ) : '#';
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

		if ( ! empty( $atts[ 'download' ] ) ) {
			$download = 'download';
		}

    if ( ! empty( $atts[ 'position' ] ) ) {
      $atts[ 'class' ] .= " {$default_class}_{$atts[ 'position' ]}";
    }

		if ( ! empty( $atts[ 'width' ] ) and 3 === $type ) {
			// { min-width } +
			$this->add_inline_styles( '', 'min-width', $atts[ 'width' ] );
		}

		if ( ! empty( $atts[ 'border' ] ) ) {
			if ( in_array( $type, array( 2, 8 ) ) ) {
				// :after { bgc } +
				$this->add_inline_styles( ':after', 'background-color', $atts[ 'border' ] );
			}

			if ( in_array( $type, array( 4, 5, 7 ) ) ) {
				// :before, :after { bgc } +
				$this->add_inline_styles( ':before', 'background-color', $atts[ 'border' ] );
				$this->add_inline_styles( ':after', 'background-color', $atts[ 'border' ] );
			}				

			if ( 6 === $type ) {
				// :after { border-bottom-color } +
				$this->add_inline_styles( ':after', 'border-bottom-color', $atts[ 'border' ] );
			}

			if ( ! empty( $atts[ 'border_width' ] ) ) {
				// :after { height } +
				if ( in_array( $type, array( 2, 8 ) ) ) {
					$this->add_inline_styles( ':after', 'height', $atts[ 'border_width' ] );
				}

				// :before, :after { height } +
				if ( in_array( $type, array( 5, 7 ) ) ) {
					$this->add_inline_styles( ':before', 'height', $atts[ 'border_width' ] );
					$this->add_inline_styles( ':after', 'height', $atts[ 'border_width' ] );
				}

				// :before, :after { width } +
				if ( 4 === $type ) {
					$this->add_inline_styles( ':before', 'width', $atts[ 'border_width' ] );
					$this->add_inline_styles( ':after', 'width', $atts[ 'border_width' ] );
				}

				// { border-top-width } +
				// :after { border-bottom-width } +
				if ( 6 === $type ) {
					$this->add_inline_styles( '', 'border-top-width', $atts[ 'border_width' ] );
					$this->add_inline_styles( ':after', 'border-bottom-width', $atts[ 'border_width' ] );
				}
			}
		}

		if ( ! empty( $atts[ 'back' ] ) and 3 === $type ) {
			// { background-color } +
			$this->add_inline_styles( '', 'background-color', $atts[ 'back' ] );
		}

		if ( ! empty( $atts[ 'text_color' ] ) ) {
			if ( 3 === $type ) {
				// { color } +
				$this->add_inline_styles( '', 'color', $atts[ 'text_color' ] );
			} else {
				// :hover { color } +
				$this->add_inline_styles( ':hover', 'color', $atts[ 'text_color' ] );
			}

			if ( 6 === $type ) {
				// :after { color } +
				$this->add_inline_styles( ':after', 'color', $atts[ 'text_color' ] );
			}
		}

		if ( ! empty( $atts[ 'text_size' ] ) ) {
			// { font-size } +
			$this->add_inline_styles( '', 'font-size', $atts[ 'text_size' ] );
		}

		if ( ! empty( $atts[ 'icon_name' ] ) and 9 === $type ) {
			$atts[ 'class' ] .= " {$default_class}_with_icon";
			if ( ( int ) $atts[ 'icon_right' ] ) {
				$atts[ 'class' ] .= " {$default_class}_with_icon_right";
			}
		}

		$this->add_shortcode_style( $id, $atts );

		return $this->display_btn( $content, $atts, $id, $rel, $target, $onclick, $download );
	}


	/**
	 * Display Blockquote.
	 *
	 * Формирует разметку элемента.
	 *
	 * @param Array  $content  - текст элемента.
	 * @param Array  $atts     - атрибуты переданные в шорткод.
	 * @param String $id       - атрибут элемента.
	 * @param String $rel      - атрибут "rel".
	 * @param String $target   - атрибут "target".
	 * @param String $onclick  - атрибут "onclick" ( в значении не допустимы символы "[" и "]" ).
	 * @param String $download - атрибут "download".
	 *
	 * @return String HTML     - разметка элемента.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function display_btn( $content, $atts, $id, $rel, $target, $onclick, $download ) {

		$lang_domain = apply_filters( 'bri_shortcode_lang_domain', $this->lang_domain );

		ob_start();
?>
		<a href="<?php echo $atts[ 'link' ] ?>" id="<?php echo $id ?>" class="<?php echo $atts[ 'class' ] ?>" data-hover="<?php _e( $content, $lang_domain ) ?>" <?php echo $rel, $target, $onclick, $download ?>>
				
			<?php if ( ! empty( $atts[ 'icon_name' ] ) and 9 === ( int ) $atts[ 'type' ] ) : ?>
				<span class="shortcode_bri_link_icon">
					<i class="fa fa-<?php echo $atts[ 'icon_name' ] ?>" aria-hidden="true"></i>
				</span>
			<?php endif; ?>

			<span class="shortcode_bri_link_label"><?php _e( $content, $lang_domain ) ?></span>

		</a>
<?php
		return trim( ob_get_clean() );
	}
}
