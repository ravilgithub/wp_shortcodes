<?php
/**
 * Класс реализует шорткод "bri_link",
 * который позволяет формировать
 * HTML разметка элемента.
 *
 * Доступные атрибуты:
 * @class         - классы ( дополнительные - left, right )
 * @link          - ссылка ( http | https ) на страницу или файл.
 * @width         - минимальная ширина элемента.
 * @border        - CSS цвет рамки
 * @border_width  - CSS ширина рамки
 * @back          - CSS цвет фона
 * @text_color    - CSS цвет текста по умолчанию для всего блока
 * @text_size     - CSS размер шрифта и зависимые от него внутренние отступы.
 * @icon_name     - часть класса иконки ( полный класс .fa.fa-{$icon_name} )
 * @icon_right    - позиция иконки: 0 - слева | 1 - справа.
 * @target        - как открывать ссылку ( _self | _parent | _blank )
 * @rel           - отношения между ссылками ( https://developer.mozilla.org/ru/docs/Web/HTML/Element
 * @download      - для скачивания файла ( 0 | 1 )
 * @onklick       - обработчик события.
 * 
 * Пример:
 * 
 */
class Bri_Link_Shortcode {
	const STYLES_PATH          = '../assets/css/';
	public $name               = 'bri_link';
	public $lang_domain        = 'bri_shortcodes_l10n';
	public $inline_styles      = array();
	public static $n           = 1;
	public $special_atts_types = array(
		'js' => array(
			'atts_names'  => array( 'onclick' ),
			'esc_handler' => 'esc_js',
		),
	);
	public $default_atts = array(
		'class'         => '',
		'type'          => 1,
		'link'          => '',
		'width'         => '',
		'border'        => '#eee',
		'border_width'  => '1px',
		'back'          => '#fff',
		'text_color'    => '#333',
		'text_size'     => '1em',
		'icon_name'     => '',
		'icon_right'    => 0,
		'target'        => '',
		'rel'           => '',
		'onclick'       => '',
		'download'      => 0,
	);


	/**
	 * Construct.
	 *
	 * @param Object $obj - может принять другой объект в котором будет обрабатываться шорткод.
	 *
	 * @return void.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function __construct( $obj = '' ) {
		$obj = ! empty( $obj ) ? $obj : $this;
		add_shortcode( $this->name, array( $obj, $this->get_full_name() ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_shortcode_style' ) );

		$this->set_lang_domain();
	}


	/**
	 * Register Shortcode CSS ( file ).
	 *
	 * Регистрируем файл стилей, только в том случае,
	 * если он был вызван в редакторе поста.
	 *
	 * @return void.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function register_shortcode_style() {
		global $post;
		if( has_shortcode( $post->post_content, $this->name ) ) {
			$style_url = self::STYLES_PATH . $this->get_full_name() . '.min.css';
			$style_url = apply_filters( $this->get_full_name() . '_style_url', $style_url );
			wp_register_style( "{$this->name}-shortcode", plugins_url( $style_url, __FILE__ ) );
		}
	}


	/**
	 * Add Inline CSS.
	 *
	 * Добавляем "inline" в свойство $inline_styles из атрибутов шорткода.
	 *
	 * @param String $selector  - CSS селектор элемента.
	 * @param String $prop_name - имя CSS свойства.
	 * @param String $val       - значение CSS свойства.
	 *
	 * @return viod
	 * @since  0.0.1
	 * @author Ravil
	 */
	public function add_inline_styles( $selector, $prop_name, $val ) {
		if ( ! array_key_exists( $selector, $this->inline_styles ) ) {
			$this->inline_styles[ $selector ] = array( $prop_name => $val );
		} else {
			$this->inline_styles[ $selector ] = array_merge( $this->inline_styles[ $selector ], array( $prop_name => $val ) );
		}
	}


	/**
	 * Retutn Structured Inline CSS.
	 *
	 * Возвращает структурированные "inline" стили.
	 *
	 * @param String $id            - идентификатор элемента.
	 * @param String $inline_styles - "inline" CSS.
	 *
	 * @return String $custom_css
	 * @since  0.0.1
	 * @author Ravil
	 */
	public function get_inline_styles( $id, $inline_styles ) {
		if ( ! empty( $inline_styles ) ) {

			$custom_css = '';
			foreach ( $inline_styles as $selector => $props ) {
				if ( empty( $props ) ) {
					continue;
				}

				if ( '' === $selector ) {
					$custom_css .= "#{$id} {\n";
				} elseif ( 0 === strpos( $selector, ':' ) ) {
					$custom_css .= "#{$id}{$selector} {\n";
				} else {
					$custom_css .= "#{$id} {$selector} {\n";
				}

				foreach ( $props as $prop => $val ) {
					$custom_css .= " {$prop}: {$val};\n";
				}

				$custom_css .= "}\n";
			}

			echo '<pre>';
			// echo "{$this->name}-shortcode inline styles\n";
			// print_r( $inline_styles );
			print_r( $custom_css );
			echo '</pre>';

			return $custom_css;
		}
	}


	/**
	 * Add Shortcode CSS ( file ) and Inline CSS if exist.
	 *
	 * Добавляем файл стилей.
	 *
	 * Добавляем "inline" стили если они определены в свойстве $inline_styles.
	 *
	 * @param String $id - идентификатор элемента.
	 *
	 * @return viod
	 * @since  0.0.1
	 * @author Ravil
	 */
	public function add_shortcode_style( $id, $atts ) {
		wp_enqueue_style( "{$this->name}-shortcode" );
		$inline_styles = apply_filters( $this->get_full_name() . '_inline_styles', $this->inline_styles, $id, $atts );

		$custom_css = $this->get_inline_styles( $id, $inline_styles );

		if ( ! empty( $custom_css ) ) {
			wp_add_inline_style( "{$this->name}-shortcode", $custom_css );
		}

		$this->inline_styles = array();
	}


	/**
	 * Register translation file.
	 *
	 * Регистрация файла перевода.
	 *
	 * @return void
	 * @since  0.0.1
	 * @author Ravil
	 */
	public function set_lang_domain() {
		$flag = load_plugin_textdomain( $this->lang_domain, false, basename( dirname( __DIR__ ) ) . '/lang' );
	}


	/**
	 * Get Shortcode Full Name .
	 *
	 * Возвращает полное имя шорткода.
	 *
	 * @return String - shortcode full name.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	function get_full_name() {
		return 'shortcode_' . $this->name;
	}


	/**
	 * Prepare Attributes.
	 *
	 * Отсечка не допустимых атрибутов. Очистка.
	 *
	 * @param Array $atts - атрибуты переданные в шорткод.
	 *
	 * @return Array      - очищенные атрибуты.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function prepare_atts( $atts ) {
		$prepared = array();
		$special_atts_types = apply_filters( $this->get_full_name() . '_special_atts_types', $this->special_atts_types );
		$default_atts = apply_filters( $this->get_full_name() . '_default_atts', $this->default_atts );

		$atts = shortcode_atts( $default_atts, $atts, $this->name );

		foreach ( $atts as $attr => $val ) {
			foreach ( $special_atts_types as $type => $opts ) {
				if ( in_array( $attr, $opts[ 'atts_names' ] ) ) {
					$esc_handler = $opts[ 'esc_handler' ];
					$prepared[ $attr ] = ( is_callable( $esc_handler ) ) ? $esc_handler( $val ) : "Обработчик - $esc_handler для атрибутов - $type не является функцией !!!";
					continue 2;
				}
			}
			$prepared[ $attr ] = esc_attr( $val );
		}

		/*echo '<pre>';
		print_r( $prepared );
		echo '</pre>';*/

		return $prepared;
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

		if ( ! empty( $atts[ 'width' ] ) and 3 === $type ) {
			// { min-width }
			$this->add_inline_styles( '', 'min-width', $atts[ 'width' ] );
		}

		if ( ! empty( $atts[ 'border' ] ) ) {
			if ( in_array( $type, array( 2, 8 ) ) ) {
				// :after { bgc }
				$this->add_inline_styles( ':after', 'background-color', $atts[ 'border' ] );
			}

			if ( in_array( $type, array( 4, 5, 7 ) ) ) {
				// :before, :after { bgc }
				$this->add_inline_styles( ':before', 'background-color', $atts[ 'border' ] );
				$this->add_inline_styles( ':after', 'background-color', $atts[ 'border' ] );
			}				

			if ( 6 === $type ) {
				// :after { border-bottom-color }
				$this->add_inline_styles( ':after', 'border-bottom-color', $atts[ 'border' ] );
			}

			if ( ! empty( $atts[ 'border_width' ] ) ) {
				// :after { height }
				if ( in_array( $type, array( 2, 8 ) ) ) {
					$this->add_inline_styles( ':after', 'height', $atts[ 'border_width' ] );
				}

				// :before, :after { height }
				if ( in_array( $type, array( 5, 7 ) ) ) {
					$this->add_inline_styles( ':before', 'height', $atts[ 'border_width' ] );
					$this->add_inline_styles( ':after', 'height', $atts[ 'border_width' ] );
				}

				// :before, :after { width }
				if ( 4 === $type ) {
					$this->add_inline_styles( ':before', 'width', $atts[ 'border_width' ] );
					$this->add_inline_styles( ':after', 'width', $atts[ 'border_width' ] );
				}

				// { border-top-width }
				// :after { border-bottom-width }
				if ( 6 === $type ) {
					$this->add_inline_styles( '', 'border-top-width', $atts[ 'border_width' ] );
					$this->add_inline_styles( ':after', 'border-bottom-width', $atts[ 'border_width' ] );
				}
			}
		}

		if ( ! empty( $atts[ 'back' ] ) and 3 === $type ) {
			// { background-color }
			$this->add_inline_styles( '', 'background-color', $atts[ 'back' ] );
		}

		if ( ! empty( $atts[ 'text_color' ] ) ) {
			if ( 3 === $type ) {
				// { color }
				$this->add_inline_styles( '', 'color', $atts[ 'text_color' ] );
			} elseif ( 6 === $type ) {
				// :hover, :after { color }
				$this->add_inline_styles( ':hover', 'color', $atts[ 'text_color' ] );
				$this->add_inline_styles( ':after', 'color', $atts[ 'text_color' ] );
			} else {
				// :hover { color }
				$this->add_inline_styles( ':hover', 'color', $atts[ 'text_color' ] );
			}
		}

		if ( ! empty( $atts[ 'text_size' ] ) ) {
			// { font-size }
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
	 * @param Array  $content    - текст элемента.
	 * @param Array  $atts       - атрибуты переданные в шорткод.
	 * @param String $id         - атрибут элемента.
	 * @param String $rel        - атрибут "rel".
	 * @param String $target     - атрибут "target".
	 * @param String $onclick    - атрибут "onclick" ( в значении не допустимы символы "[" и "]" ).
	 * @param String $download   - атрибут "download".
	 *
	 * @return String HTML       - разметка элемента.
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
