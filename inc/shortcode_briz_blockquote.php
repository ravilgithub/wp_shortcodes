<?php
namespace Briz_Shortcodes;

/**
 * Класс реализует шорткод "briz_blockquote",
 * который позволяет формировать
 * HTML разметку цитаты.
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
 *   @class             - классы ( дополнительные - left, right )
 *   @position          - обтeкание ( left | right )
 *   @border            - CSS цвет рамки
 *   @border_width      - CSS ширина рамки
 *   @back              - CSS цвет фона
 *   @text_color        - CSS цвет текста по умолчанию для всего блока
 *   @decor_icon_name   - часть класса декоративной иконки ( полный класс .fa.fa-{$icon_name} )
 *   @decor_icon_color  - CSS цвет декоративной иконки
 *   @author_icon_name  - часть класса иконки автора ( полный класс .fa.fa-{$icon_name} )
 *   @author_icon_color - CSS цвет иконки автора
 *   @author_name       - имя автора
 *   @author_name_color - CSS цвет имени автора
 *   @author_meta       - дополнительная информация об авторе
 *   @author_link       - ссылка на автора ( http | https )
 * }
 * 
 * Пример:
 * [briz_blockquote
 *  class="left custom_class col-lg-6"
 *  position=""
 *  border="#aa4"
 *  border_width="1px"
 *  back="#efe"
 *  text_color=""
 *  decor_icon_name=""
 *  decor_icon_color="#c0c"
 *  author_icon_name="user-o"
 *  author_icon_color="magenta"
 *  author_name="John Smith"
 *  author_meta="Repairing Manager"
 *  author_name_color="#3cc"
 *  author_link="http://ya.ru"
 * ]
 *  Content
 * [/briz_blockquote]
 *
 * @since 0.0.1
 * @author Ravil
 */
class Briz_Blockquote_Shortcode extends Briz_Shortcodes {
	public $name   = 'briz_blockquote';
	public $assets = [
		'css' => [
			'briz_blockquote' => [
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
	 * Функция обработчик шорткода "briz_blockquote".
	 *
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $content - контент переданный между парными тегами шорткода.
	 * @param String $tag     - имя шорткода указанный первым параметром в фукции "add_shortcode".
	 *
	 * @return String HTML    - разметка сформированного шорткода.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function shortcode_briz_blockquote( $atts, $content, $tag ) {
		$default_class = $this->get_full_name();
		$id            = $default_class . '_' . self::$n++;

		$content = wp_kses( $content, 'post' );
		
		if ( empty( $content ) )
			return false;

		$atts = $this->prepare_atts( $atts );
		
		$atts[ 'class' ] .= ( ! empty( $atts[ 'class' ] ) ) ? " $default_class" : $default_class;

		if ( ! empty( $atts[ 'position' ] ) ) {
			$atts[ 'class' ] .= " {$default_class}_{$atts[ 'position' ]}";
		}

		if ( ! empty( $atts[ 'border' ] ) ) {
			$this->add_inline_styles( '', 'border-color', $atts[ 'border' ] );
			$atts[ 'class' ] .= " {$default_class}_border";
			if ( ! empty( $atts[ 'border_width' ] ) ) {
				$this->add_inline_styles( '', 'border-width', $atts[ 'border_width' ] );
			}
		}

		if ( ! empty( $atts[ 'back' ] ) ) {
			$this->add_inline_styles( '', 'background-color', $atts[ 'back' ] );
			$atts[ 'class' ] .= " {$default_class}_back";
		}

		if ( ! empty( $atts[ 'text_color' ] ) ) {
			$this->add_inline_styles( '.shortcode_briz_blockquote_summary', 'color', $atts[ 'text_color' ] );
		}

		if ( ! empty( $atts[ 'decor_icon_name' ] ) ) {
			$atts[ 'class' ] .= " {$default_class}_with_decor_icon";
		}

		if ( ! empty( $atts[ 'decor_icon_color' ] ) ) {
			$this->add_inline_styles( '.shortcode_briz_blockquote_decor_icon .fa', 'color', $atts[ 'decor_icon_color' ] );
		}

		if ( ! empty( $atts[ 'author_icon_color' ] ) ) {
			$this->add_inline_styles( '.shortcode_briz_blockquote_author_icon .fa', 'color', $atts[ 'author_icon_color' ] );
		}

		if ( ! empty( $atts[ 'author_name_color' ] ) ) {
			$this->add_inline_styles( '.shortcode_briz_blockquote_author_name', 'color', $atts[ 'author_name_color' ] );
		}

		$this->add_shortcode_style( $id, $atts );

		return $this->display_blockquote( $content, $id, $atts );
	}


	/**
	 * Display Blockquote.
	 *
	 * Формирует разметку цитаты.
	 *
	 * @param Array  $content - текст цитаты.
	 * @param Array  $atts    - атрибуты переданные в шорткод.
	 * @param String $id      - атрибут элемента.
	 *
	 * @return String HTML    - разметка цитаты.
	 * @since	 0.0.1
	 * @author Ravil
	 */
	public function display_blockquote( $content, $id, $atts ) {

		$lang_domain = apply_filters( 'briz_shortcode_lang_domain', $this->lang_domain );

		ob_start();
?>
		<q id="<?php echo $id ?>" class="<?php echo $atts[ 'class' ] ?>">

			<?php if ( ! empty( $atts[ 'decor_icon_name' ] ) ) : ?>
				<span class="shortcode_briz_blockquote_decor_icon">
					<i class="fa fa-<?php echo $atts[ 'decor_icon_name' ] ?>" aria-hidden="true"></i>
				</span>
			<?php endif ?>

			<span class="shortcode_briz_blockquote_summary">
				<em class="shortcode_briz_blockquote_content"><?php echo $content ?></em>

				<?php if ( ! empty( $atts[ 'author_name' ] ) ) : ?>
					<span class="shortcode_briz_blockquote_author_info">

						<?php if ( ! empty( $atts[ 'author_icon_name' ] ) ) : ?>
							<span class="shortcode_briz_blockquote_author_icon">
								<i class="fa fa-<?php echo $atts[ 'author_icon_name' ] ?>" aria-hidden="true"></i>
							</span>
						<?php endif ?>

						<span class="shortcode_briz_blockquote_author_details">
							<strong class="shortcode_briz_blockquote_author_name">

								<?php if ( ! empty( $atts[ 'author_link' ] ) && wp_http_validate_url( $atts[ 'author_link' ] ) ) : ?>
									<a href="<?php echo esc_url( $atts[ 'author_link' ] ) ?>" target="_blank" class="shortcode_briz_blockquote_author_link"><?php _e( $atts[ 'author_name' ], $lang_domain ) ?></a>
								<?php else : ?>
									<?php _e( $atts[ 'author_name' ], $lang_domain ) ?>
								<?php endif ?>

							</strong>

							<?php if ( ! empty( $atts[ 'author_meta' ] ) ) : ?>
								<em class="shortcode_briz_blockquote_author_meta"><?php _e( $atts[ 'author_meta' ], $lang_domain ) ?></em>
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
