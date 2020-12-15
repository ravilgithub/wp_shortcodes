<?php
/**
 * Класс реализует шорткод "bri_btn",
 * который позволяет формировать
 * HTML разметка элемента.
 *
 * Доступные атрибуты:
 * @class         - классы ( дополнительные - left, right )
 * @btn           - 0 - <a> | 1 - <button>
 * @link          - ссылка ( http | https ) на страницу или файл.
 * @width         - минимальная ширина элемента.
 * @border        - CSS цвет рамки
 * @border_width  - CSS ширина рамки
 * @back          - CSS цвет фона
 * @text_color    - CSS цвет текста по умолчанию для всего блока
 * @text_size     - CSS размер шрифта и зависимые от него внутренние отступы.
 * @shadow        - тень ( 0 | 1 )
 * @rounded       - закругление краёв ( 0 | 1 )
 * @animation     - анимация при наведении курсора ( fade | slide )
 * @icon_name     - часть класса иконки ( полный класс .fa.fa-{$icon_name} )
 * @icon_right    - позиция иконки: 0 - слева | 1 - справа.
 * @icon_separate - иконка как отдельный элемент ( 0 | 1 )
 * @target        - как открывать ссылку ( _self | _parent | _blank )
 * @rel           - отношения между ссылками ( https://developer.mozilla.org/ru/docs/Web/HTML/Element
 * @download      - для скачивания файла ( 0 | 1 )
 * @onklick       - обработчик события.
 * 
 * Пример:
 * [bri_blockquote class="left custom_class col-lg-6" border="#aa4" border_width="1px" back="#efe" text_color="" decor_icon_name="" decor_icon_color="#c0c" author_icon_name="user-o" author_icon_color="magenta" author_name="John Smith" author_meta="Repairing Manager" author_name_color="#3cc" author_link="http://ya.ru"]Content[/bri_blockquote]
 */
class Bri_Btn_Shortcode {
	const STYLES_PATH    = '../assets/css/';
	public $name         = 'bri_btn';
	public $lang_domain  = 'bri_shortcodes_l10n';
	public $inline_style = array();
	public static $n     = 1;
	public $special_atts_types = array(
		'js' => array(
			'atts_names'  => array( 'onclick' ),
			'esc_handler' => 'esc_js',
		),
	);
	public $default_atts = array(
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
		'target'        => '',
		'rel'           => '',
		'download'      => 0,
		'onclick'       => '',
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
		$inline_style = apply_filters( $this->get_full_name() . '_inline_style', $this->inline_style, $id, $atts );
		$custom_css = "";

		if ( ! empty( $inline_style ) ) {
			// $custom_css .= "#{$id}:hover {\n";
			$custom_css .= "#{$id} {\n";
			foreach ( $inline_style as $prop => $val ) {
				$custom_css .= " {$prop}: {$val};\n";
			}
			$custom_css .= "}";

			wp_add_inline_style( "{$this->name}-shortcode", $custom_css );
		}

		/*echo '<pre>';
		echo "{$this->name}-shortcode inline styles\n";
		print_r( $inline_style );
		echo '</pre>';*/
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
		// $this->lang_domain = apply_filters( 'bri_shortcode_lang_domain', $this->lang_domain );

		// $flag = load_plugin_textdomain( $this->lang_domain, false, 'bri_shortcodes/lang' );
		
		$flag = load_plugin_textdomain( $this->lang_domain, false, basename( dirname( __DIR__ ) ) . '/lang' );
		
		// $flag = load_textdomain( $this->lang_domain, plugin_dir_path( __DIR__ ) . 'lang/' . get_locale() . '.mo' );

		// echo '<br /> 0 ';
		// echo plugins_url( 'lang' , dirname(__FILE__) );
		/*echo plugin_dir_path( dirname(__FILE__) );
		echo '<br />';
		echo plugin_dir_path( __FILE__ );
		echo '<br />';
		echo trailingslashit( dirname( __FILE__ ) );
		echo '<br />';*/

		// echo '<br /> 1 ';
		// echo plugin_basename( dirname(__FILE__) ) . '/lang';

		// echo '<br /> 2 ';
		// echo plugin_dir_path( dirname(__FILE__) );

		// echo '<br /> 3 ';
		// echo basename(dirname(dirname(__FILE__))) . '/lang';

		// echo '<br /> 3 ';
		// echo basename(dirname(__DIR__)) . '/lang';
		
		// echo '<br /> 4 ';
		// echo plugin_dir_path( dirname(__FILE__) ) . 'lang/' . get_locale() . '.mo';

		// echo '<br /> 5 ';
		// echo dirname(__FILE__);

		// echo '<br /> 6 ';
		// echo plugin_dir_path( __DIR__ ) . 'lang/' . get_locale() . '.mo<br />';

		/*if ( $flag ) {
			echo 'Ok';
		} else {
			echo 'Bad';
		}*/
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

		/*$atts = array_map( function( $item ) {
			return esc_attr( $item );
		}, $atts );*/

		/*foreach ( $atts as $attr => $val ) {
			if ( in_array( $attr, $special_atts_types[ 'js' ] ) ) {
				$prepared[ $attr ] = esc_js( $val );
				echo $prepared[ $attr ];
				continue;
			}
			$prepared[ $attr ] = esc_attr( $val );
		}*/

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
	 * Функция обработчик шорткода "bri_btn".
	 *
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $content - контент переданный между парными тегами шорткода.
	 * @param String $tag     - имя шорткода указанный первым параметром в фукции "add_shortcode".
	 *
	 * @return String HTML    - разметка сформированного шорткода.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function shortcode_bri_btn( $atts, $content, $tag ) {
		$default_class = $this->get_full_name();
		$id            = $default_class . '_' . self::$n++;
		$width         = '';
		$bd_color      = '';
		$bd_width      = '';
		$bg_color      = '';
		$text_color    = '';
		$text_size     = '';
		$target        = '';
		$rel           = '';
		$download      = '';
		$onclick       = '';

		$content = wp_kses( $content, 'post' );
		
		if ( empty( $content ) )
			return false;

		$atts = $this->prepare_atts( $atts );
		
		$atts[ 'class' ] .= ( ! empty( $atts[ 'class' ] ) ) ? " $default_class" : $default_class;

		// $target = ( ! empty( $atts[ 'target' ] ) ) ? 'target="' . $atts[ 'target' ] . ';"' : '';
		// $rel = ( ! empty( $atts[ 'rel' ] ) ) ? 'rel="' . $atts[ 'rel' ] . ';"' : '';
		// $onclick = ( ! empty( $atts[ 'onclick' ] ) ) ? 'onclick="' . $atts[ 'onclick' ] . ';"' : '';

		if ( ( int ) $atts[ 'type' ] ) {
			$atts[ 'class' ] .= " {$default_class}_type_{$atts[ 'type' ]}";
		}

		if ( ! ( int ) $atts[ 'btn' ] ) {
			/*if ( ! empty( $atts[ 'link' ] ) && wp_http_validate_url( $atts[ 'link' ] ) ) {
				$atts[ 'link' ] = esc_url( $atts[ 'link' ] ) ? esc_url( $atts[ 'link' ] ) : '#';
			} else {
				$atts[ 'link' ] = '#';
			}*/

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
				// $download = 'download="' . $atts[ 'download' ] . '"';
			}
		}

		if ( ! empty( $atts[ 'width' ] ) ) {
			$width = "min-width:{$atts[ 'width' ]};";
		}

		if ( ! empty( $atts[ 'border' ] ) ) {
			
			/*if ( 2 === ( int ) $atts[ 'type' ] ) {
				$bd_color = "border-color:{$atts[ 'border' ]};";
			} else {
				$bd_color = "border-color:{$atts[ 'border' ]};";
			}*/

			$bd_color = "border-color:{$atts[ 'border' ]};";
			$atts[ 'class' ] .= " {$default_class}_border";
			// $this->inline_style[ 'border-color' ] = $atts[ 'border' ]; // test
			if ( ! empty( $atts[ 'border_width' ] ) ) {
				$bd_width = "border-width:{$atts[ 'border_width' ]};";
				// $this->inline_style[ 'border-width' ] = $atts[ 'border_width' ]; // test
			}
		}

		if ( ! empty( $atts[ 'back' ] ) ) {
			$bg_color = "background-color:{$atts[ 'back' ]};";
			$atts[ 'class' ] .= " {$default_class}_back";
			// $this->inline_style[ 'background-color' ] = $atts[ 'back' ]; // test
		}

		if ( ! empty( $atts[ 'text_color' ] ) ) {
			$text_color = "color:{$atts[ 'text_color' ]};";
			// $this->inline_style[ 'color' ] = $atts[ 'text_color' ]; // test
		}

		if ( ! empty( $atts[ 'text_size' ] ) ) {
			$text_size = "font-size:{$atts[ 'text_size' ]};";
			// $this->inline_style[ 'font-size' ] = $atts[ 'text_size' ]; // test
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

		return $this->display_btn( $content, $atts, $id, $width, $bd_color, $bd_width, $bg_color, $text_color, $text_size, $rel, $target, $download, $onclick );
	}


	/**
	 * Display Button.
	 *
	 * Формирует разметку элемента.
	 *
	 * @param Array  $content    - текст элемента.
	 * @param Array  $atts       - атрибуты переданные в шорткод.
	 * @param String $id         - атрибут элемента.
	 * @param String $width      - минимальная ширина элемента.
	 * @param String $bd_color   - CSS цвет рамки.
	 * @param String $bd_width   - CSS ширина рамки.
	 * @param String $bg_color   - CSS цвет фона.
	 * @param String $text_color - CSS цвет текста.
	 * @param String $text_size  - CSS размер текста.
	 * @param String $rel        - атрибут "rel".
	 * @param String $target     - атрибут "target".
	 * @param String $download   - атрибут "download".
	 * @param String $onclick    - атрибут "onclick" ( в значении не допустимы символы "[" и "]" ).
	 *
	 * @return String HTML       - разметка элемента.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function display_btn( $content, $atts, $id, $width, $bd_color, $bd_width, $bg_color, $text_color, $text_size, $rel, $target, $download, $onclick ) {

		$lang_domain = apply_filters( 'bri_shortcode_lang_domain', $this->lang_domain );

		ob_start();
		if ( ( int ) $atts[ 'btn' ] ) :
?>
			<button id="<?php echo $id ?>" class="<?php echo $atts[ 'class' ] ?>" style="<?php echo $width, $bd_color, $bd_width, $bg_color, $text_color, $text_size ?>" <?php echo $onclick ?>>
		
<?php else : ?>

			<a href="<?php echo $atts[ 'link' ] ?>" id="<?php echo $id ?>" class="<?php echo $atts[ 'class' ] ?>" style="<?php echo $width, $bd_color, $bd_width, $bg_color, $text_color, $text_size ?>" <?php echo $rel, $target, $onclick, $download ?>>

<?php endif; ?>
				
				<?php if ( ! empty( $atts[ 'icon_name' ] ) ) : ?>
					<span class="shortcode_bri_btn_icon">
						<i class="fa fa-<?php echo $atts[ 'icon_name' ] ?>" aria-hidden="true"></i>
					</span>
				<?php endif; ?>

				<span class="shortcode_bri_btn_label"><?php _e( $content, $lang_domain ) ?></span>

<?php if ( ( int ) $atts[ 'btn' ] ) : ?>	
			</button>
<?php else : ?>
			</a>
<?php
		endif;

		return trim( ob_get_clean() );
	}
}
