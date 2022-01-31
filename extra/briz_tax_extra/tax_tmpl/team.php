<?php
	namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl;
	use Briz_Shortcodes\common\Helper;


	/**
	 * Team template.
	 *
	 * Формирование вывода шаблона "team".
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
	class Team {
		private $tmpl_name = 'briz-team-tmpl';
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
?>
			<section
				id="<?php echo esc_attr( $this->id ); ?>"
				class="<?php echo esc_attr( $this->tmpl_name ); ?> showcase section blog-page <?php echo $class ?>"
				data-shortcode-term-id="<?php echo esc_attr( $this->curr_term_id ); ?>"
			>
				<div class="section-inner-wrap">
					<div class="container">
						<div class="row">
							<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
								<div class="section-caption">
									<h2>Team <span>members</span></h2>
									<div class="spacer">
										<div class="diamond"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="section-content-wrap">
									<div class="swiper-container">
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
									</div> <!-- .swiper -->
								</div> <!-- .section-content-wrap -->
							</div> <!-- .col-sm-12 -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div> <!-- .section-inner-wrap -->
			</section> <!-- .briz-blog-tmpl -->
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
			$placeholder = esc_url( PLUGIN_URL . '/img/placeholder/team/placeholder.png' );
			foreach ( $posts[ 'data' ] as $data ) :
				$query = $data[ 'query' ];

				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
					$post_id = get_the_id();

					$img_url = $placeholder;
					$img_title = '';
					$img_alt = '';
					if ( has_post_thumbnail() ) {
						$img_url = esc_url( get_the_post_thumbnail_url() );
						$attach_id = get_post_thumbnail_id( $post_id );
						$img_title = esc_attr( get_the_title( $attach_id ) );
						$img_alt = esc_attr( get_post_meta( $attach_id, '_wp_attachment_image_alt', true ) );
						// $img_caption = esc_attr( wp_get_attachment_caption( $attach_id ) );
						// $img_caption = esc_attr( get_the_excerpt( $attach_id ) );
					}

					$meta_key = Helper::get_post_meta_key( __CLASS__, $query );
					$opts = get_post_meta( $post_id, $meta_key, true );
					$member_info = $opts[ 'member_info' ];
					$link_to_post = $opts[ 'link_to_post' ];
?>
					<div class="swiper-slide">
						<div class="slide-inner-wrap">
							<div class="team-member-img">
								<div class="swiper-lazy-preloader"></div>
								<img
									class="swiper-lazy"
									src="<?php echo $placeholder ?>"
									data-src="<?php echo $img_url ?>"
									title="<?php echo $img_title ?>"
									alt="<?php echo $img_alt ?>"
								/>
<?php
									if (
										array_key_exists( 'social', $opts ) &&
										is_array( $opts[ 'social' ] ) &&
										$social = $opts[ 'social' ]
									) :
?>
										<div class="team-member-overlay">
											<div class="social-links">
<?php
												foreach ( $social as $item ) :
													$social_url = esc_url( $item[ 'social_url' ] );
													$social_icon = esc_attr( $item[ 'social_icon' ] );
?>
													<a href="<?php echo $social_url; ?>">
														<i class="fa fa-<?php echo $social_icon; ?>"></i>
													</a>
												<?php endforeach; ?>
											</div>
										</div>
<?php
									endif;
?>
							</div> <!-- .team-member-img -->
							<div class="team-member-info">
<?php
								if ( ! $link_to_post ) {
									the_title( '<h4>', '</h4>' );
								} else {
									the_title( sprintf( '<h4><a href="%s">', esc_url( get_permalink() ) ), '</a></h4>' );
								}

								if ( $member_info ) :
?>
									<p><?php echo $member_info; ?></p>
<?php
								endif;
?>
							</div> <!-- .team-member-info -->
						</div> <!-- .slide-inner-wrap -->
					</div> <!-- .swiper-slide -->
<?php
				endwhile;
				wp_reset_postdata();
				endif;
			endforeach;
		}
	}
