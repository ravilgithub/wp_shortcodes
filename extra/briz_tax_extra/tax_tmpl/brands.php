<?php
	namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl;
	use Briz_Shortcodes\common\Helper;

	/**
	 * Review template.
	 *
	 * Формирование вывода шаблона "brands".
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
	class Brands {
		private $tmpl_name = 'briz-brands-tmpl';
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

			$slider_atts = [];
			if (
				is_array( $opts ) &&
				array_key_exists( 'slider_params', $opts ) &&
				! empty( $opts[ 'slider_params' ] )
			) {
				$slider_atts = $opts[ 'slider_params' ];
			}
?>
			<section
				id="<?php echo esc_attr( $this->id ); ?>"
				class="<?php echo esc_attr( $this->tmpl_name ); ?> showcase section brands-page <?php echo $class ?>"
				data-shortcode-term-id="<?php echo esc_attr( $this->curr_term_id ); ?>"
			>

				<div class="section-inner-wrap">
					<div class="container">
						<div class="row">
							<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
								<div class="section-caption">
									<h2>B<span>rands</span></h2>
									<div class="spacer">
										<div class="diamond"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div
									class="swiper-container"
									data-slider-custom-atts="<?php echo esc_attr( json_encode( $slider_atts ) ); ?>"
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

									<div class="swiper-pagination"></div>
									<div class="swiper-button-prev"></div>
									<div class="swiper-button-next"></div>
								</div> <!-- .swiper-container -->
							</div> <!-- .col-sm-12 -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div> <!-- .section-inner-wrap -->
			</section> <!-- .briz-brands-tmpl -->
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
			$placeholder = esc_url( PLUGIN_URL . '/img/placeholder/review/placeholder.png' );
			foreach ( $posts[ 'data' ] as $data ) :
				$query = $data[ 'query' ];

				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
					$meta_key = Helper::get_post_meta_key( __CLASS__, $query );
					$post_id = get_the_id();
					$opts = get_post_meta( $post_id, $meta_key, true );

					if ( ! is_array( $opts ) )
						return;
					if ( ! array_key_exists( 'media', $opts ) )
						return;
					if ( ! $media = json_decode( $opts[ 'media' ] ) )
						return;

					foreach ( $media as $media_id ) :
						// $img_url = esc_url( wp_get_attachment_url( $attach_id ) );
						// $img_title = esc_attr( get_the_title( $attach_id ) );
						// $img_alt = esc_attr( get_post_meta( $attach_id, '_wp_attachment_image_alt', true ) );

						$details = wp_prepare_attachment_for_js( $media_id );
						$src = $details[ 'url' ];
						$type = $details[ 'type' ];

?>
						<div class="swiper-slide">
							<div class="swiper-lazy-preloader"></div>
<?php
							// Image
							if ( 'image' == $type ) :
?>
								<img
									class="swiper-lazy"
									src="<?php echo esc_attr( $placeholder ); ?>"
									data-src="<?php echo esc_attr( $src ); ?>"
									alt="<?php echo esc_attr( $details[ 'alt' ] ); ?>"
								/>
<?php
							endif;

							// Audio
							if ( 'audio' == $type ) :
?>
								<audio
									class="swiper-lazy"
									src="<?php echo esc_attr( $placeholder ); ?>"
									data-src="<?php echo esc_attr( $src ); ?>"
									controls>
								</audio>
<?php
							endif;

							// Video
							if ( 'video' == $type ) :
?>
								<video
									class="swiper-lazy"
									src="<?php echo esc_attr( $placeholder ); ?>"
									data-src="<?php echo esc_attr( $src ); ?>"
									controls>
								</video>
<?php
							endif;
?>
						</div> <!-- .swiper-slide -->
<?php
					endforeach;
				endwhile;
				wp_reset_postdata();
				endif;
			endforeach;
		}
	}
