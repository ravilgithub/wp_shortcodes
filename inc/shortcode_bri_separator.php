<?php
/**
 * Класс реализует шорткод "bri_saparator",
 * который позволяет формировать
 * HTML разметку элемента.
 *
 * Доступные атрибуты:
 * @class         - дополнительные классы.
 * @width         - ширина элемента.
 * @margin_top    - верхний внешний отступ элемента.
 * @margin_bottom - нижний внешний отступ в элемента.
 * @border_width  - CSS ширина рамки.
 * @border_style  - CSS стиль рамки.
 * @border_color  - CSS цвет рамки.
 * @text_color    - CSS цвет текста при наведении на блок.
 * @text_size     - CSS размер шрифта.
 * @position      - обтeкание ( left | center | right )
 * @back          - CSS цвет фона элемента.
 * @diamond       - Использовать ли декорацию вместо контента ( 0 | 1 ).
 * 
 * Пример:
 * [bri_separator position="center" border_color="#f00" text_color="#00f" text_size="2em"]Content[/bri_separator]
 */

namespace Bri_Shortcodes;

class Bri_Separator_Shortcode extends Bri_Shortcodes {
  public $name   = 'bri_separator';
  public $assets = [
    'css' => [
      'bri_separator' => [
        'deps' => [
          'bri-fontawesome-css'
        ],
        'ver'  => '1.0.0'
      ],
    ]
  ];
  public $inline_styles = array();
  public static $n      = 1;
  public $default_atts  = array(
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
  );


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
   * Функция обработчик шорткода "bri_separator".
   *
   * @param Array  $atts    - атрибуты переданные в шорткод.
   * @param String $content - контент переданный между парными тегами шорткода.
   * @param String $tag     - имя шорткода указанный первым параметром в фукции "add_shortcode".
   *
   * @return String HTML    - разметка сформированного шорткода.
   * @since  0.0.1
   * @author Ravil
   */
  public function shortcode_bri_separator( $atts, $content, $tag ) {
    $default_class = $this->get_full_name();
    $id            = $default_class . '_' . self::$n++;

    $content = wp_kses( $content, 'post' );
    
    /*if ( empty( $content ) )
      return false;*/

    $atts = $this->prepare_atts( $atts );
    
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
        // .shortcode_bri_separator_content_wrap .shortcode_bri_separator_diamond { border-width }
        $this->add_inline_styles( '.shortcode_bri_separator_content_wrap .shortcode_bri_separator_diamond', 'border-width', $atts[ 'border_width' ] );

        if ( ! empty( $atts[ 'border_style' ] ) ) {
          // .shortcode_bri_separator_content_wrap .shortcode_bri_separator_diamond { border-style }
          $this->add_inline_styles( '.shortcode_bri_separator_content_wrap .shortcode_bri_separator_diamond', 'border-style', $atts[ 'border_style' ] );
        }

        if ( ! empty( $atts[ 'border_color' ] ) ) {
          // .shortcode_bri_separator_content_wrap .shortcode_bri_separator_diamond { border-color }
          $this->add_inline_styles( '.shortcode_bri_separator_content_wrap .shortcode_bri_separator_diamond', 'border-color', $atts[ 'border_color' ] );
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
        // .shortcode_bri_separator_content_wrap .shortcode_bri_separator_diamond { width }
        $this->add_inline_styles( '.shortcode_bri_separator_content_wrap .shortcode_bri_separator_diamond', 'width', $atts[ 'text_size' ] );

        // .shortcode_bri_separator_content_wrap .shortcode_bri_separator_diamond { height }
        $this->add_inline_styles( '.shortcode_bri_separator_content_wrap .shortcode_bri_separator_diamond', 'height', $atts[ 'text_size' ] );
      }
    }

    if ( ! empty( $atts[ 'text_size' ] ) && ! empty( $atts[ 'border_width' ] ) ) {
      $fz = $atts[ 'text_size' ];
      $bdw = $atts[ 'border_width' ];
      $top = "calc( $fz / -2 - $bdw / 2 )";

      // .shortcode_bri_separator_content_wrap { top }
      $this->add_inline_styles( '.shortcode_bri_separator_content_wrap', 'top', $top );
    }

    if ( ! empty( $atts[ 'back' ] ) ) {
      // .shortcode_bri_separator_content_wrap { background-color }
      $this->add_inline_styles( '.shortcode_bri_separator_content_wrap', 'background-color', $atts[ 'back' ] );
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

    $lang_domain = apply_filters( 'bri_shortcode_lang_domain', $this->lang_domain );

    ob_start();
?>
    <div id="<?php echo $id ?>" class="<?php echo $atts[ 'class' ] ?>">
      <?php if ( $atts[ 'diamond' ] ) : ?>
        <div class="shortcode_bri_separator_content_wrap">
          <div class="shortcode_bri_separator_diamond"></div>
        </div>
      <?php elseif ( ! empty( $content ) ) : ?>
        <div class="shortcode_bri_separator_content_wrap">
          <?php _e( $content, $lang_domain ) ?>
        </div>
      <?php endif; ?>
    </div>
<?php
    return trim( ob_get_clean() );
  }
}
