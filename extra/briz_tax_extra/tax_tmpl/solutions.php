<?php
	namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl;
	use Briz_Shortcodes\common\Helper;

	/**
	 * Solutions template.
	 *
	 * Формирование вывода шаблона "solutions".
	 *
	 * @property String $tmpl_name        - имя шаблона.
	 * @property String $content          - контент шорткода.
	 * @property Array $atts              - параметры шорткода.
	 * @property String $id               - id шорткода.
	 * @property String $lang_domain      - id перевода шорткода.
	 * @property Integer $curr_term_id    - id активного термина( tab'a ).
	 * @property Integer $all_posts_count - количество записей термина или
	 *                                      всех терминов.
	 * @since 0.0.1
	 * @author Ravil
	 */
	class Solutions {
		private $tmpl_name = 'briz-solutions-tmpl';
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

			$section_class = '';
			$header = false;
			$header_first = '';
			$header_last = '';
			$header_spacer = false;
			$header_description = false;
			$header_description_text = '';
			$header_bg_color = '';
			$content_bg_color = '';

			if ( is_array( $opts ) ) {
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
			}
?>
			<section
				id="<?php echo esc_attr( $this->id ); ?>"
				class="showcase section solutions-page
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
				</div> <!-- .section-content-wrap -->
			</section> <!-- .briz-solutions-tmpl -->
<?php
		}


		/**
		 * Template "Accordion".
		 *
		 * Шаблон "Accordion".
		 *
		 * @param Array $sections - мета поля шаблона.
		 *
		 * @return viod
		 *
		 * @since 0.0.1
		 * @author Ravil
		 */
		private function get_accordeon( $sections ) {
			ob_start();

			$is_first = 'active';
?>
			<div class="accordion-container">
<?php
				foreach ( $sections as $section ) :
					if ( $section[ 'enable' ] ) : // ??? $section['value']['enable']
						$title = __( $section[ 'title' ], $this->lang_domain );
						$content = __( $section[ 'content' ], $this->lang_domain );
?>
						<div class="accordion-item <?php echo $is_first; ?>">
							<div class="accordion-item-header">
								<h3><?php echo $title; ?></h3>
							</div>
							<div class="accordion-item-content">
								<p><?php echo $content; ?></p>
							</div>
						</div>
<?php
					endif;

					$is_first = '';
				endforeach;
?>
			</div>
<?php
			ob_end_flush();
		}


		/**
		 * Template "Tabs".
		 *
		 * Шаблон "Tabs".
		 *
		 * @param Array $sections - мета поля шаблона.
		 *
		 * @return viod
		 *
		 * @since 0.0.1
		 * @author Ravil
		 */
		public function get_tabs( $sections ) {
?>
			<div class="tabs-container">
				<ul class="tabs-list clearfix">
<?php 
					$is_first = 'active';
					foreach ( $sections as $section_name => $section ) :
						if ( ! $section['enable'] )
							continue;

						$icon = esc_attr( $section[ 'icon' ] );
						$href = esc_attr( $section_name );
						$title = __( $section[ 'title' ], $this->lang_domain	);
?>
						<li class="<?php echo $is_first; ?>">
							<a href="#<?php echo $href; ?>">
								<i class="fa fa-<?php echo $icon; ?>" aria-hidden="true"></i>
								<?php echo $title; ?>
							</a>
						</li>
<?php
						$is_first = '';
					endforeach;
?>
				</ul>
				<div class="tabs-content">
<?php
					$is_first = 'active';
					foreach ( $sections as $section_name => $section ) :
						if ( ! $section[ 'enable' ] )
							continue;

						$id = esc_attr( $section_name );
						$content = __( $section[ 'content' ], $this->lang_domain );
?>
						<div class="tab-content-inner <?php echo $is_first; ?>" id="<?php echo $id; ?>">
							<p><?php echo $content; ?></p>
						</div>
<?php
						$is_first = '';
					endforeach;
?>
				</div>
			</div>
<?php
		}


		/**
		 * Template "Progress bar".
		 *
		 * Шаблон "Progress bar".
		 *
		 * @param Array $sections - мета поля шаблона.
		 *
		 * @return viod
		 *
		 * @since 0.0.1
		 * @author Ravil
		 */
		public function get_progress_bar( $sections ) {
?>
			<div class="wow progress-bar-container clearfix">
<?php
				foreach ( $sections as $section ) :
					$title = __( $section[ 'title' ], $this->lang_domain );
					$num = esc_attr( ( int ) $section[ 'target_number' ] );
					$symbol = esc_attr( $section[ 'symbol' ] );
					$symbol_position = esc_attr( $section[ 'symbol_position' ] );
?>
					<div class="progress-bar-item" data-progress-target="<?php echo $num; ?>">
						<h3><?php echo $title; ?></h3>
						<div class="ruler-wrap">
							<div
								class="ruler"
								data-ruler="0"
								data-symbol="<?php echo $symbol; ?>"
								data-symbol-position="<?php echo $symbol_position; ?>"
							></div>
						</div>
					</div>
<?php
				endforeach;
?>
			</div>
<?php
		}


		/**
		 * Checking if template output is allowed ( accordion, tabs, ... ).
		 *
		 * Проверка, разрешен ли вывод шаблона ( accordion, tabs, ... ).
		 *
		 * @param Array $opts        - мета поля записи.
		 * @param String $field_name - имя мета поля, значение которого,
		 *                             необходимо проверить на истинность.
		 * @return Boolean
		 *
		 * @since 0.0.1
		 * @author Ravil
		 */
		private function check_fields( $opts, $field_name ) {
			if (
				is_array( $opts ) &&
				array_key_exists( $field_name, $opts ) &&
				array_key_exists( 'enable', $opts[ $field_name ] ) &&
				$opts[ $field_name ][ 'enable' ] &&
				array_key_exists( 'sections', $opts[ $field_name ] )
			) {
				return true;
			}
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
			$meta_key = Helper::get_post_meta_key( __CLASS__, $posts[ 'data' ][ 0 ][ 'query' ] );
			$term_opts = get_term_meta( $this->curr_term_id, $meta_key, true );

			$content_width_class = 'container';

			if ( is_array( $term_opts ) ) {
				if ( array_key_exists( 'content_wide', $term_opts ) ) {
					$content_width_class = $term_opts[ 'content_wide' ] ? 'container-fluid' : $content_width_class;
				}
			}

			foreach ( $posts[ 'data' ] as $data ) :
				$child = $data[ 'child' ];
				$query = $data[ 'query' ];

				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
					$post_id = get_the_id();
					$post_opts = get_post_meta( $post_id, $meta_key, true );

					if ( empty( $post_opts ) )
						return false;

					$post_opts[ 'post_id' ] = $post_id;

					$content_bg_color = '';
					$content_position = '';
					$bg_position = ' left';
					$theme_color = '';
					$glassy = '';

					$post_title = __( get_the_title() , $this->lang_domain );
					$post_content = __( get_the_content( '' ), $this->lang_domain );

					// list( $bg, $attachment, $parallax_data, $parallax_img_src ) = Helper::get_bg_atts( $post_opts );
					list( $bg, $attachment, $parallax_data, $parallax_img_src ) = Helper::get_bg_atts( $post_opts, true, 'bg_img', 'bg_attachment' );

					if (
						! $parallax_img_src &&
						array_key_exists( 'content_bg_color_enable', $post_opts ) &&
						! empty( $post_opts[ 'content_bg_color_enable' ] ) &&
						array_key_exists( 'content_bg_color', $post_opts )
					) {
						$content_bg_color = ' background-color: ' . esc_attr( $post_opts[ 'content_bg_color' ] ) . ';';
					}

					if ( array_key_exists( 'position', $post_opts ) ) {
						if ( 'right' == $post_opts[ 'position' ] ) {
							$bg_position = ' right';
							$content_position = ' col-md-offset-6';
						}
					}

					if ( array_key_exists( 'theme_color', $post_opts ) ) {
						$theme_color = $post_opts[ 'theme_color' ];
					}

					if (
						array_key_exists( 'glassy', $post_opts ) &&
						! empty( $post_opts[ 'glassy' ] )
					) {
						$glassy = ' glassy';
					}
?>
					<div 
						class="solution-item <?php echo esc_attr( $attachment ), $bg_position; ?>"
						style="<?php echo esc_attr( $bg ), $content_bg_color; ?>"
						data-parallax="<?php echo esc_attr( $parallax_data ); ?>"
						data-image-src="<?php echo esc_attr( $parallax_img_src ); ?>"
					>
						<div class="<?php echo $content_width_class; ?>">
							<div class="row">
								<div
									class="solution-inner col-md-6 <?php echo esc_attr( $theme_color ), $content_position, $glassy; ?>"
								>
									<div class="solution-item-caption">
										<h2><?php echo $post_title; ?></h2>
										<?php echo $post_content; ?>
									</div>
<?php
									if (
										array_key_exists( 'solution_elements', $post_opts ) &&
										! empty( $els = $post_opts[ 'solution_elements' ] )
									) {
										foreach ( Helper::sort( $els ) as $el_name => $el_params ) {
											$method_name = 'get_' . $el_name;
											if ( method_exists( $this, $method_name ) ) {
												$this->$method_name( $el_params[ 'sections' ] );
											}
										}
									}
?>
								</div>
							</div>
						</div>
					</div>
<?php
				endwhile;
				wp_reset_postdata();
				endif;
			endforeach;
		}
	}
