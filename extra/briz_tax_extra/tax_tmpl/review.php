<?php
	namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl;
	use Briz_Shortcodes\common\Helper;

	/**
	 * Review template.
	 *
	 * Формирование вывода шаблона "review".
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
	class Review {
		private $tmpl_name = 'briz-review-tmpl';
		public $content;
		public $atts;
		public $id;
		public $lang_domain;
		public $curr_term_id;
		public $all_posts_count = 0;


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
			$this->lang_domain = $lang_domain;
			$this->curr_term_id = $curr_term_id;
			$this->redefine_script_tag();
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
			$content_bg_color = '';
			$content_width_class = 'container';

			if ( is_array( $opts ) ) {
				if (
					array_key_exists( 'slider_params', $opts ) &&
					! empty( $opts[ 'slider_params' ] )
				) {
					$slider_atts = esc_attr( json_encode( $opts[ 'slider_params' ] ) );
				}

				if ( array_key_exists( 'header', $opts ) ) {
					if ( $opts[ 'header' ] ) {
						$header = true;
						$section_class = 'section-with-header';
					}
				}

				if ( array_key_exists( 'header_first', $opts ) ) {
					$header_first = __( $opts[ 'header_first' ], $this->lang_domain );
				}

				if ( array_key_exists( 'header_last', $opts ) ) {
					$header_last = __( $opts[ 'header_last' ], $this->lang_domain );
				}

				if ( array_key_exists( 'header_spacer', $opts ) ) {
					$header_spacer = $opts[ 'header_spacer' ] ? true : $header_spacer;
				}

				if ( array_key_exists( 'header_description', $opts ) ) {
					$header_description = $opts[ 'header_description' ] ? true : $header_description;
				}

				if ( array_key_exists( 'header_description_text', $opts ) ) {
					$header_description_text = __( $opts[ 'header_description_text' ], $this->lang_domain );
				}

				if (
					! empty( $opts[ 'header_bg_color_enable' ] ) &&
					array_key_exists( 'header_bg_color_enable', $opts ) &&
					array_key_exists( 'header_bg_color', $opts )
				) {
					$header_bg_color = 'background-color: ' . esc_attr( $opts[ 'header_bg_color' ] ) . ';';
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
				class="showcase section review-page
					<?php echo esc_attr( $this->tmpl_name ); ?>
					<?php echo esc_attr( $class ); ?>
					<?php echo $section_class; ?>
				"
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
								<div class="slider-box">
									<div class="swiper-navigation">
										<div class="swiper-button-prev-custom"></div>
										<div class="swiper-button-next-custom"></div>
										<!-- <div class="swiper-pagination-custom"></div> -->
									</div> <!-- .swiper-navigation -->

									<div
										class="swiper"
										data-slider-custom-atts="<?php echo $slider_atts; ?>"
									>
										<div class="swiper-wrapper">
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
										</div> <!-- .swiper-wrapper -->
									</div> <!-- .swiper -->
								</div> <!-- .slider-box -->
							</div> <!-- .col-sm-12 -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div> <!-- .section-content-wrap -->
			</section> <!-- .briz-review-tmpl -->
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
			// $placeholder = esc_url( PLUGIN_URL . '/img/placeholder/review/placeholder.png' );
			foreach ( $posts[ 'data' ] as $data ) :
				$query = $data[ 'query' ];

				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
					$post_id = get_the_id();

					// $img_url = $placeholder;
					$img_url = '';
					$img_title = '';
					$img_alt = '';
					$aspect_ratio = 'initial';
					if ( has_post_thumbnail() ) {
						$attach_id = get_post_thumbnail_id( $post_id );
						list( $img_url, $img_width, $img_height ) = wp_get_attachment_image_src( $attach_id, 'full' );
						// $img_url = esc_url( get_the_post_thumbnail_url() );
						$img_title = esc_attr__( get_the_title( $attach_id ), $this->lang_domain );
						$img_alt = esc_attr__( get_post_meta( $attach_id, '_wp_attachment_image_alt', true ), $this->lang_domain );
						// $img_caption = esc_attr( wp_get_attachment_caption( $attach_id ) );
						// $img_caption = esc_attr( get_the_excerpt( $attach_id ) );
						$aspect_ratio = $img_width / $img_height;
					}

					$meta_key = Helper::get_post_meta_key( __CLASS__, $query );
					$opts = get_post_meta( $post_id, $meta_key, true );
					$member_info = array_key_exists( 'member_info', $opts ) ? __( $opts[ 'member_info' ], $this->lang_domain ) : null;
					$post_title = __( get_the_title(), $this->lang_domain );
					$post_content = __( get_the_content( '' ), $this->lang_domain );
?>
					<div class="swiper-slide">
						<div class="slide-inner-wrap">
							<div class="review-text clearfix">
								<span><i class="fa fa-quote-left" aria-hidden="true"></i></span>
								<?php echo $post_content; ?>
							</div>

							<div class="review-customer">
								<div class="customer-img">
									<div class="swiper-lazy-preloader-custom"></div>
									<img
										class="swiper-lazy"
										src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
										data-src="<?php echo esc_url( $img_url ); ?>"
										title="<?php echo $img_title; ?>"
										alt="<?php echo $img_alt; ?>"
										style="aspect-ratio: <?php echo $aspect_ratio; ?>;"
									/>
								</div>

								<div class="customer-info clearfix">
									<h4><?php echo $post_title; ?></h4>
<?php
									if ( $member_info ) :
?>
										<p><?php echo $member_info; ?></p>
<?php
									endif;
?>
								</div>
							</div> <!-- .review-customer -->
						</div> <!-- .slide-inner-wrap -->
					</div> <!-- .swiper-slide -->
<?php
				endwhile;
				wp_reset_postdata();
				endif;
			endforeach;
		}
	}
