<?php
/**
 * Класс реализует шорткод "bri_blockquote",
 * который позволяет формировать
 * HTML разметка цитаты.
 *
 * Доступные атрибуты:
 * @class             - классы ( дополнительные - left, right )
 * @position          - обтeкание ( left | right )
 * @border            - CSS цвет рамки
 * @border_width      - CSS ширина рамки
 * @back              - CSS цвет фона
 * @text_color        - CSS цвет текста по умолчанию для всего блока
 * @decor_icon_name   - часть класса декоративной иконки ( полный класс .fa.fa-{$icon_name} )
 * @decor_icon_color  - CSS цвет декоративной иконки
 * @author_icon_name  - часть класса иконки автора ( полный класс .fa.fa-{$icon_name} )
 * @author_icon_color - CSS цвет иконки автора
 * @author_name       - имя автора
 * @author_name_color - CSS цвет имени автора
 * @author_meta       - дополнительная информация об авторе
 * @author_link       - ссылка на автора ( http | https )
 * 
 * Пример:
 * [bri_blockquote class="left custom_class col-lg-6" border="#aa4" border_width="1px" back="#efe" text_color="" decor_icon_name="" decor_icon_color="#c0c" author_icon_name="user-o" author_icon_color="magenta" author_name="John Smith" author_meta="Repairing Manager" author_name_color="#3cc" author_link="http://ya.ru"]Content[/bri_blockquote]
 */
class Bri_Blockquote_Shortcode {
	const STYLES_PATH        = '../assets/css/';
	public $name             = 'bri_blockquote';
	public $default_atts     = array(
		'class'             => '',
		'position'          => '',
		'border'            => '#ccc',
		'border_width'      => '0 0 0 5px',
		'back'              => '#fafafa',
		'text_color'        => '#999',
		'decor_icon_name'   => 'quote-left',
		'decor_icon_color'  => '#aaa',
		'author_icon_name'  => 'user',
		'author_icon_color' => '#999',
		'author_name'       => '',
		'author_name_color' => '#90c948',
		'author_meta'       => '',
		'author_link'       => '',
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
		add_action( 'wp_enqueue_scripts', array( $this, 'add_shortcode_css' ) );
	}


	/**
	 * Add Shortcode CSS.
	 *
	 * Подключаем файл стилей только в том случае,
	 * если он был вызван в редакторе поста.
	 *
	 * @return void.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function add_shortcode_css() {
		global $post;
		if( has_shortcode( $post->post_content, $this->name ) ) {
			$style_url = self::STYLES_PATH . $this->get_full_name() . '.min.css';
			$style_url = apply_filters( $this->get_full_name() . '_style_url', $style_url );
			wp_enqueue_style( "{$this->name}-shortcode", plugins_url( $style_url, __FILE__ ) );
		}
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
		$default_atts = apply_filters( $this->get_full_name() . '_default_atts', $this->default_atts );

		$atts = shortcode_atts( $default_atts, $atts, $this->name );

		$atts = array_map( function( $item ) {
			return esc_attr( $item );
		}, $atts );

		return $atts;
	}


	/**
	 * List shortcode callback.
	 *
	 * Функция обработчик шорткода "bri_list".
	 *
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $content - контент переданный между парными тегами шорткода.
	 * @param String $tag     - имя шорткода указанный первым параметром в фукции "add_shortcode".
	 *
	 * @return String HTML    - разметка сформированного шорткода.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function shortcode_bri_blockquote( $atts, $content, $tag ) {
		$default_class     = $this->get_full_name();
		$bd_color          = '';
		$bd_width          = '';
		$bg_color          = '';
		$text_color        = '';
		$decor_icon_color  = '';
		$author_icon_color = '';
		$author_name_color = '';

		$content = wp_kses( $content, 'post' );
		
		if ( empty( $content ) )
			return false;

		$atts = $this->prepare_atts( $atts );
		
		$atts[ 'class' ] .= ( ! empty( $atts[ 'class' ] ) ) ? " $default_class" : $default_class;

		if ( ! empty( $atts[ 'position' ] ) ) {
			$atts[ 'class' ] .= " {$default_class}_{$atts[ 'position' ]}";
		}

		if ( ! empty( $atts[ 'border' ] ) ) {
			$bd_color .= "border-color:{$atts[ 'border' ]};";
			$atts[ 'class' ] .= " {$default_class}_border";
			if ( ! empty( $atts[ 'border_width' ] ) ) {
				$bd_width .= "border-width:{$atts[ 'border_width' ]};";
			}
		}

		if ( ! empty( $atts[ 'back' ] ) ) {
			$bg_color .= "background-color:{$atts[ 'back' ]};";
			$atts[ 'class' ] .= " {$default_class}_back";
		}

		if ( ! empty( $atts[ 'text_color' ] ) ) {
			$text_color .= "color:{$atts[ 'text_color' ]};";
		}

		if ( ! empty( $atts[ 'decor_icon_name' ] ) ) {
			$atts[ 'class' ] .= " {$default_class}_with_decor_icon";
		}

		if ( ! empty( $atts[ 'decor_icon_color' ] ) ) {
			$decor_icon_color .= "color:{$atts[ 'decor_icon_color' ]};";
		}

		if ( ! empty( $atts[ 'author_icon_color' ] ) ) {
			$author_icon_color .= "color:{$atts[ 'author_icon_color' ]};";
		}

		if ( ! empty( $atts[ 'author_name_color' ] ) ) {
			$author_name_color .= "color:{$atts[ 'author_name_color' ]};";
		}
			
		return $this->display_blockquote( $content, $atts, $bd_color, $bd_width, $bg_color, $decor_icon_color, $text_color, $author_icon_color, $author_name_color );
	}


	/**
	 * Display Blockquote.
	 *
	 * Формирует разметку цитаты.
	 *
	 * @param Array  $content      			- текст цитаты.
	 * @param Array  $atts         			- атрибуты переданные в шорткод.
	 * @param String $bd_color     			- CSS цвет рамки.
	 * @param String $bd_width     			- CSS ширина рамки.
	 * @param String $bg_color     			- CSS цвет фона.
	 * @param String $decor_icon_color  - CSS цвет декоративной иконки.
	 * @param String $text_color 				- CSS цвет нумерации.
	 * @param String $author_icon_color - CSS цвет иконки автора.
	 * @param String $author_name_color - CSS цвет имени автора.
	 *
	 * @return String HTML         			- разметка цитаты.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function display_blockquote( $content, $atts, $bd_color, $bd_width, $bg_color, $decor_icon_color, $text_color, $author_icon_color, $author_name_color ) {
		ob_start();
?>
		<q class="<?php echo $atts[ 'class' ] ?>" style="<?php echo $bd_color, $bd_width, $bg_color ?>">

			<?php if ( ! empty( $atts[ 'decor_icon_name' ] ) ) : ?>
				<span class="shortcode_bri_blockquote_decor_icon">
					<i class="fa fa-<?php echo $atts[ 'decor_icon_name' ] ?>" style="<?php echo $decor_icon_color ?>" aria-hidden="true"></i>
				</span>
			<?php endif ?>

			<span class="shortcode_bri_blockquote_summary" class="<?php echo $text_color ?>">
				<em class="shortcode_bri_blockquote_content"><?php echo $content ?></em>

				<?php if ( ! empty( $atts[ 'author_name' ] ) ) : ?>
					<span class="shortcode_bri_blockquote_author_info">

						<?php if ( ! empty( $atts[ 'author_icon_name' ] ) ) : ?>
							<span class="shortcode_bri_blockquote_author_icon">
								<i class="fa fa-<?php echo $atts[ 'author_icon_name' ] ?>" style="<?php echo $author_icon_color ?>" aria-hidden="true"></i>
							</span>
						<?php endif ?>

						<span class="shortcode_bri_blockquote_author_details">
							<strong class="shortcode_bri_blockquote_author_name" style="<?php echo $author_name_color ?>">

								<?php if ( ! empty( $atts[ 'author_link' ] ) && wp_http_validate_url( $atts[ 'author_link' ] ) ) : ?>
									<a href="<?php echo esc_url( $atts[ 'author_link' ] ) ?>" target="_blank" class="shortcode_bri_blockquote_author_link"><?php echo $atts[ 'author_name' ] ?></a>
								<?php else : ?>
									<?php echo $atts[ 'author_name' ] ?>
								<?php endif ?>

							</strong>

							<?php if ( ! empty( $atts[ 'author_meta' ] ) ) : ?>
								<em class="shortcode_bri_blockquote_author_meta"><?php echo $atts[ 'author_meta' ] ?></em>
							<?php endif ?>
							
						</span>
					</span>

				<?php endif ?>

			</span>
		</q>		
<?php
		return trim( ob_get_clean() );
	}
}
