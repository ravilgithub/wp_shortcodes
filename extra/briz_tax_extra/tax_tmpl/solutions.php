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

			$opts = get_term_meta( $term_id, 'briz_term_meta', true );
			list( $bg, $attachment, $parallax_data, $parallax_img_src ) = Helper::get_bg_atts( $opts, true, 'bg_img', 'bg_attachment' );
?>
			<section
				id="<?php echo esc_attr( $this->id ); ?>"
				class="<?php echo esc_attr( $this->tmpl_name ); ?> showcase section solutions-page <?php echo $class ?> <?php echo esc_attr( $attachment ); ?>"
				style="<?php echo esc_attr( $bg ); ?>"
				data-parallax="<?php echo esc_attr( $parallax_data ); ?>"
				data-image-src="<?php echo esc_attr( $parallax_img_src ); ?>"
				data-shortcode-term-id="<?php echo esc_attr( $this->curr_term_id ); ?>"
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
			</section> <!-- .briz-solutions-tmpl -->
<?php
		}


		/**
		 * Template "Accordeon".
		 *
		 * Шаблон "Accordeon".
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
			<div class="accordeon-container">
<?php
				foreach ( $sections as $section ) :
					if ( $section[ 'enable' ] ) :
?>
						<div class="accordeon-item <?php echo $is_first; ?>">
							<div class="accordeon-item-header">
								<h5><?php _e( $section[ 'title' ], $this->lang_domain ); ?></h5>
							</div>
							<div class="accordeon-content">
								<p><?php _e( $section[ 'content' ], $this->lang_domain ); ?></p>
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
						$icon = esc_attr( $section[ 'icon' ] );
						$href = esc_attr( $section_name );
						$title = __( $section[ 'title' ], $this->lang_domain	);
?>
						<li class="<?php echo $is_first ?>">
							<a
								href="#<?php echo $href ?>"
								class="fa fa-<?php echo $icon ?>"
							>
								<?php echo $title ?>
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
						if ( $section[ 'enable' ] ) :
							$id = esc_attr( $section_name );
							$content = __( $section[ 'content' ], $this->lang_domain );
?>
							<div class="tab-content-inner <?php echo $is_first ?>" id="<?php echo $id ?>">
								<p><?php echo $content ?></p>
							</div>
<?php
						endif;
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
					$title = $section[ 'title' ];
					$num = esc_attr( ( int ) $section[ 'target_number' ] );
					$symbol = esc_attr( $section[ 'symbol' ] );
					$symbol_position = esc_attr( $section[ 'symbol_position' ] );
?>
					<div class="progress-bar-item" data-progress-target="<?php echo $num; ?>">
						<h5><?php echo $title; ?></h5>
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
			foreach ( $posts[ 'data' ] as $data ) :
				$child = $data[ 'child' ];
				$query = $data[ 'query' ];

				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
					$post_id = get_the_id();
					$opts = get_post_meta( $post_id, '_category_solutions', true );

					$opts[ 'post_id' ] = $post_id;

					$content_position = '';
					$bg_position = 'left';
					$bg_color = '';
					$glassy = '';

					list( $bg, $attachment, $parallax_data, $parallax_img_src ) = Helper::get_bg_atts( $opts );

					if ( array_key_exists( 'position', $opts ) ) {
						if ( 'right' == $opts[ 'position' ] ) {
							$bg_position = 'right';
							$content_position = 'col-md-offset-6';
						}
					}

					if ( array_key_exists( 'bg_color', $opts ) ) {
						$bg_color = $opts[ 'bg_color' ];
					}

					if (
						array_key_exists( 'glassy', $opts ) &&
						! empty( $opts[ 'glassy' ] )
					) {
						$glassy = 'glassy';
					}
?>
					<div 
						class="bg-overlay <?php echo esc_attr( $bg_position ); ?> <?php echo esc_attr( $attachment ); ?>"
						style="<?php echo esc_attr( $bg ); ?>"
						data-parallax="<?php echo esc_attr( $parallax_data ); ?>"
						data-image-src="<?php echo esc_attr( $parallax_img_src ); ?>"
					>
						<div class="container-fluid">
							<div class="row">
								<div class="solution-wrap col-md-6 <?php echo esc_attr( $content_position . ' ' . $bg_color . ' ' . $glassy ); ?>">
									<div class="solution-inner-wrap">
										<div class="section-caption">
											<?php the_title( '<h2>', '</h2>'); ?>
											<?php the_content(); ?>
										</div>
<?php
										if ( $this->check_fields( $opts, 'accordeon' ) ) {
											$this->get_accordeon( $opts[ 'accordeon' ][ 'sections' ] );
										}

										if ( $this->check_fields( $opts, 'tabs' ) ) {
											$this->get_tabs( $opts[ 'tabs' ][ 'sections' ] );
										}

										if ( $this->check_fields( $opts, 'tabs_2' ) ) {
											$this->get_tabs( $opts[ 'tabs_2' ][ 'sections' ] );
										}

										if ( $this->check_fields( $opts, 'progress_bar' ) ) {
											$this->get_progress_bar( $opts[ 'progress_bar' ][ 'sections' ] );
										}
?>
									</div>
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
