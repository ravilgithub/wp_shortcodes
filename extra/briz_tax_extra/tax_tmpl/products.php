<?php
	namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl;

	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}

	use Briz_Shortcodes\inc\Briz_Tax_Shortcode;
	use Briz_Shortcodes\common\Helper;

	use Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\Actions;

	/**
	 * Products template.
	 *
	 * Формирование вывода шаблона "products".
	 *
	 * @property String $tmpl_name        - имя шаблона.
	 * @property String $content          - контент шорткода.
	 * @property Array $atts              - параметры шорткода.
	 * @property String $id               - id шорткода.
	 * @property String $lang_domain      - id перевода шорткода.
	 * @property Integer $curr_term_id    - id активного термина( tab'a ).
	 * @property Integer $all_posts_count - количество записей термина или всех терминов.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	class Products {
		use Actions;

		private $tmpl_name = 'briz-products-tmpl';
		public $content;
		public $atts;
		public $id;
		public static $lang_domain;
		public $curr_term_id;
		public $all_posts_count = 0;
		public $slider_atts = '';


		/**
		 * Constructor
		 *
		 * @param String $content       - контент шорткода.
		 * @param Array $atts           - параметры шорткода.
		 * @param String $id            - id шорткода.
		 * @param String $lang_domain   - id перевода шорткода.
		 * @param Integer $curr_term_id - id активного термина( tab'a ).
		 *
		 * @return void
		 *
		 * @since 0.0.1
		 * @author Ravil
		 */
		public function __construct( $content = '', $atts = [], $id = '', $lang_domain = '', $curr_term_id = null ) {
			$this->content = $content;
			$this->atts = $atts;
			$this->id = $id;
			self::$lang_domain = $lang_domain;
			$this->curr_term_id = $curr_term_id;
			$this->redefine_script_tag();

			$this->add_actions();
		}


		/**
		 * Adding previously registered styles and template scripts.
		 *
		 * Добавление ранее зарегистрированных стилей и скриптов шаблона.
		 *
		 * @return void
		 *
		 * @since 0.0.1
		 * @author Ravil
		 */
		public function add_tmpl_assets() {
			wp_enqueue_style( $this->tmpl_name . '-css' );
			wp_enqueue_script( $this->tmpl_name . '-js' );
		}


		/**
		 * Adding a filter to override the attributes of the 'script' tag.
		 *
		 * Добавление фильтра для переопределения атрибутов тега 'script'.
		 *
		 * @return void
		 *
		 * @since 0.0.1
		 * @author Ravil
		 * */
		public function redefine_script_tag() {
			add_filter( 'script_loader_tag', [ $this, 'set_module_attr' ], 10, 3 );
		}


		/**
		 * We indicate that the script is a module and, accordingly
		 * will be able to import
		 * functionality from other modules.
		 *
		 * Указываем, что скрипт - это модуль и соответственно
		 * будет иметь возможность импортировать
		 * функционал из других модулей.
		 *
		 * @param String $tag    - HTML код тега <script>.
		 * @param String $handle - Название скрипта (рабочее название),
		 *                         указываемое первым параметром в
		 *                         функции wp_enqueue_script().
		 * @param String $src    - Ссылка на скрипт.
		 *
		 * @return String $tag   - HTML код тега <script>.
		 *
		 * @since 0.0.1
		 * @author Ravil
		 * */
		public function set_module_attr( $tag, $handle, $src ) {
			$module_handle = $this->tmpl_name . '-js';
			if ( $module_handle === $handle )
				$tag = '<script type="module" src="' . $src . '" id="' . $module_handle . '-js"></script>';
			return $tag;
		}


		/**
		 * Before content part of template.
		 *
		 * Часть шаблона выводимая перед контентом.
		 *
		 * @param Array $posts
		 *  Array $posts[ 'atts' ]  - параметры шорткода.
		 *  Array $posts[ 'child' ] - термин записи которого выводятся.
		 *  Array $posts[ 'query' ] - WP Query Object.
		 *
		 * @return void
		 *
		 * @since 0.0.1
		 * @author Ravil
		 */
		public function get_before( $posts ) {
			extract( $this->atts );

			$meta_key = Helper::get_post_meta_key( __CLASS__, $posts[ 'data' ][ 0 ][ 'query' ] );
			$opts = get_term_meta( $this->curr_term_id, $meta_key, true );
			list( $bg, $attachment, $parallax_data, $parallax_img_src ) = Helper::get_bg_atts( $opts, true, 'bg_img', 'bg_attachment' );

			$slider_atts = [];
			$section_class = '';
			$header = false;
			$header_first = '';
			$header_last = '';
			$header_spacer = false;
			$header_description = false;
			$header_description_text = '';
			$header_bg_color = '';
			$tab_bg_color = '';
			$content_bg_color = '';
			$content_width_class = 'container';

			if ( is_array( $opts ) ) {
				if (
					array_key_exists( 'slider_params', $opts ) &&
					! empty( $opts[ 'slider_params' ] )
				) {
					$this->slider_atts = esc_attr( json_encode( $opts[ 'slider_params' ] ) );
				}

				if ( array_key_exists( 'header', $opts ) ) {
					if ( $opts[ 'header' ] ) {
						$header = true;
						$section_class .= ' section-with-header';
					}
				}

				if ( array_key_exists( 'header_first', $opts ) ) {
					$header_first = __( $opts[ 'header_first' ], self::$lang_domain );
				}

				if ( array_key_exists( 'header_last', $opts ) ) {
					$header_last = __( $opts[ 'header_last' ], self::$lang_domain );
				}

				if ( array_key_exists( 'header_spacer', $opts ) ) {
					$header_spacer = $opts[ 'header_spacer' ] ? true : $header_spacer;
				}

				if ( array_key_exists( 'header_description', $opts ) ) {
					$header_description = $opts[ 'header_description' ] ? true : $header_description;
				}

				if ( array_key_exists( 'header_description_text', $opts ) ) {
					$header_description_text = __( $opts[ 'header_description_text' ], self::$lang_domain );
				}

				if (
					! empty( $opts[ 'header_bg_color_enable' ] ) &&
					array_key_exists( 'header_bg_color_enable', $opts ) &&
					array_key_exists( 'header_bg_color', $opts )
				) {
					$header_bg_color = 'background-color: ' . esc_attr( $opts[ 'header_bg_color' ] ) . ';';
				}

				if (
					! empty( $opts[ 'tab_bg_color_enable' ] ) &&
					array_key_exists( 'tab_bg_color_enable', $opts ) &&
					array_key_exists( 'tab_bg_color', $opts )
				) {
					$tab_bg_color = 'background-color: ' . esc_attr( $opts[ 'tab_bg_color' ] ) . ';';
				}

				if (
					! $parallax_img_src &&
					array_key_exists( 'content_bg_color_enable', $opts ) &&
					! empty( $opts[ 'content_bg_color_enable' ] ) &&
					array_key_exists( 'content_bg_color', $opts )
				) {
					$content_bg_color = ' background-color: ' . esc_attr( $opts[ 'content_bg_color' ] ) . ';';
				}

				if ( array_key_exists( 'content_wide', $opts ) ) {
					$content_width_class = $opts[ 'content_wide' ] ? 'container-fluid' : $content_width_class;
				}
			}
?>
			<section
				id="<?php echo esc_attr( $this->id ); ?>"
				class="showcase section products-page
					<?php echo esc_attr( $this->tmpl_name ); ?>
					<?php echo esc_attr( $class ); ?>
					<?php echo $section_class; ?>"
				data-shortcode-term-id="<?php echo esc_attr( $this->curr_term_id ); ?>"
			>
<?php
			if ( $header ) :
?>
				<div
					class="section-caption-wrap"
					style="<?php echo $header_bg_color; ?>"
				>
					<div class="container">
						<div class="row">
							<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
<?php
							if ( $header_first ||  $header_last ) :
?>
								<h2>
									<?php echo $header_first; ?>
									<span>
										<?php echo $header_last; ?>
									</span>
								</h2>
<?php
							endif;
							if ( $header_spacer ) :
?>
								<div class="briz-caption-spacer">
									<div class="diamond"></div>
								</div>
<?php
							endif;
							if ( $header_description && $header_description_text ) :
?>
								<p><?php echo $header_description_text; ?></p>
<?php
							endif;
?>
							</div> <!-- .col- -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div> <!-- .section-caption-wrap -->
<?php
			endif;

			// echo '<br />term id - '       . $this->curr_term_id;
			// echo '<br />term name - '     . $term[ $this->curr_term_id ][ 'tmpl_name' ];
			// echo '<br />term path - '     . $term[ $this->curr_term_id ][ 'tmpl_path' ];
			// echo '<br />taxonomy - '      . $term[ $this->curr_term_id ][ 'taxonomy' ];
			// echo '<br />operator - '      . $operator;
			// echo '<br />self - '          . $self;
			// echo '<br />children - '      . $children;
			// echo '<br />grandchildren - ' . $grandchildren;
			// echo '<br />limit - '         . $limit;
			// echo '<br />offset - '        . $offset;
			// echo '<br />orderby - '       . $orderby;
			// echo '<br />order - '         . $order;
			// echo '<br />meta key - '      . $meta_key;
			// echo '<br />show more - '     . $show_more;

			$childrens = Briz_Tax_Shortcode::get_term_childrens( $this->curr_term_id, $term[ $this->curr_term_id ][ 'taxonomy' ], $this->atts );

			if ( $children || $grandchildren ) :
?>
				<div
					class="section-tabs-wrap"
					style="<?php echo $tab_bg_color; ?>"
				>
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<ul class="tabs-list clearfix">
<?php
								$is_first = 'active';

								foreach ( $childrens as $child ) :
									$this->all_posts_count += $child->count;
									$term_id = esc_attr( $child->term_id );
									$term_posts_count = esc_attr( $child->count );
									$term_slug = esc_attr( $child->slug );
									$term_name = __( $child->name, self::$lang_domain );
?>
									<li
										class="tab-item <?php echo $is_first; ?>"
										data-term-id="<?php echo $term_id; ?>"
										data-term-posts-count="<?php echo $term_posts_count; ?>"
									>
										<a href="#<?php echo $term_slug; ?>" class="tab-anchor"><?php echo $term_name; ?></a>
									</li>
<?php
									$is_first = '';
								endforeach;
?>
								</ul> <!-- .isotop-filter -->
							</div> <!-- .col-sm-12 -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div> <!-- .section-tabs-wrap -->
<?php
			else :
				$this->all_posts_count = $childrens[ 0 ]->count;
			endif;
?>
				<div
					class="section-content-wrap <?php echo esc_attr( $attachment ); ?>"
					style="<?php echo esc_attr( $bg ), $content_bg_color; ?>"
					data-parallax="<?php echo esc_attr( $parallax_data ); ?>"
					data-image-src="<?php echo esc_attr( $parallax_img_src ); ?>"
				>
					<div class="<?php echo $content_width_class; ?>">
						<div class="row">
							<div class="col-sm-12">
<?php
		}


		/**
		 * After content part of template.
		 *
		 * Часть шаблона выводимая после контента.
		 *
		 * @param Array $posts
		 *  Array $posts[ 'atts' ]  - параметры шорткода.
		 *  Array $posts[ 'child' ] - термин записи которого выводятся.
		 *  Array $posts[ 'query' ] - WP Query Object.
		 *
		 * @return void
		 *
		 * @since 0.0.1
		 * @author Ravil
		 */
		public function get_after( $posts ) {
			extract( $this->atts );
?>
							</div> <!-- .col-sm-12 -->
						</div> <!-- .row -->
					</div> <!-- .container [ -fluid ] -->
				</div> <!-- .section-content-wrap -->
			</section> <!-- .briz-products-tmpl -->
<?php
		}


		/**
		 * Content of template.
		 *
		 * Контент шаблона.
		 *
		 * @param Array $posts
		 *  Array $posts[ 'atts' ]  - параметры шорткода.
		 *  Array $posts[ 'child' ] - термин записи которого выводятся.
		 *  Array $posts[ 'query' ] - WP Query Object.
		 *
		 * @return void
		 *
		 * @since 0.0.1
		 * @author Ravil
		 */
		public function get_content( $posts ) {
			foreach ( $posts[ 'data' ] as $k => $data ) :
				$child = $data[ 'child' ];
				$query = $data[ 'query' ];

				$id = esc_attr( $child->slug );
				$class = ( 0 === $k ) ? 'active' : '';
?>
				<div id="<?php echo $id; ?>" class="tab-content-inner <?php echo $class; ?>">
					<div class="swiper-navigation">
						<div class="swiper-button-prev-custom"></div>
						<div class="swiper-button-next-custom"></div>
						<!-- <div class="swiper-pagination-custom"></div> -->
					</div>

					<div
						class="swiper"
						data-slider-custom-atts="<?php echo $this->slider_atts; ?>"
					>
						<div class="swiper-wrapper">
<?php
						if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
							$post_id = get_the_id();
							$term_slug = esc_attr( $child->slug );
?>
							<div class="swiper-slide">
								<div class="<?php echo implode( ' ', get_post_class( 'product-thumb' ) ); ?>">
									<div class="product-block-inner clearfix">
<?php
										/**
										 * @see Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\Actions
										 */

										// Image
										do_action( 'shortcode_briz_tax_before_product_image' );
											
										// Image / Link
										do_action( 'shortcode_briz_tax_before_product_image_link' );
										do_action( 'shortcode_briz_tax_after_product_image_link' );

										// Image / Buttons
										do_action( 'shortcode_briz_tax_before_product_buttons' );
										do_action( 'shortcode_briz_tax_after_product_buttons' );

										do_action( 'shortcode_briz_tax_after_product_image' );

										// Caption
										do_action( 'shortcode_briz_tax_before_product_caption' );
										do_action( 'shortcode_briz_tax_after_product_caption' );
?>
									</div> <!-- .product-block-inner -->
								</div> <!-- .product-thumb -->
							</div> <!-- .swiper-slide -->
<?php
						endwhile;
						wp_reset_postdata();
						endif;
?>
						</div> <!-- .swiper-wrapper -->
					</div> <!-- .swiper -->
				</div> <!-- .tab-content-inner -->
<?php
			endforeach;
		}
	}
