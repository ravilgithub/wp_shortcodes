<?php
	namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl;
	use Briz_Shortcodes\common\Helper;

	/**
	 * Features template.
	 *
	 * Формирование вывода шаблона "features".
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
	class Features {
		private $tmpl_name = 'briz-features-tmpl';
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
		 * Prepare a link to tab elements.
		 *
		 * Подготавливаем ссылку на элементы табуляции.
		 *
		 * Разбиваем строку по произвольному числу
		 * запятых и пробельных символов, которые включают в себя:
		 * " ", \r, \t, \n и \f
		 * Пример:
		 *  "Hypertext language, programming" преобразуется в
		 *  "_hypertext_language_programming"
		 *
		 * @param String $label - значение метаполя "label".
		 *
		 * @return String $anchor - подготовленная ссылка на элемент.
		 *
		 * @since 0.0.1
		 * @author Ravil
		 */
		public function prepareAnchor( $label ) {
			$anchor = '';
			$parts = preg_split( '/[\s,]+/', strtolower( $label ) );

			if ( ! empty( $parts ) )
				$anchor = $this->id . '_' . implode( '_', $parts );

			return $anchor;
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

			$header_first_word = '';
			$header_last_word = '';

			if ( is_array( $opts ) ) {
				if ( array_key_exists( 'section_header_first', $opts ) ) {
					$header_first_word = $opts[ 'section_header_first' ];
				}

				if ( array_key_exists( 'section_header_last', $opts ) ) {
					$header_last_word = $opts[ 'section_header_last' ];
				}
			}
?>
			<section
				id="<?php echo esc_attr( $this->id ); ?>"
				class="<?php echo esc_attr( $this->tmpl_name ); ?> showcase section features-page <?php echo $class ?>"
				data-shortcode-term-id="<?php echo esc_attr( $this->curr_term_id ); ?>"
			>
				<div class="features-wrap">
					<div class="features-inner-wrap">
						<div class="container">
<?php
						if ( $header_first_word ||  $header_last_word ) :
?>
							<div class="row">
								<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
									<div class="section-caption">
										<h2>
											<?php _e( $header_first_word, $this->lang_domain ); ?>
											<span>
												<?php _e( $header_last_word, $this->lang_domain ); ?>
											</span>
										</h2>
										<div class="spacer">
											<div class="diamond"></div>
										</div>
									</div>
								</div>
							</div>
<?php
						endif;
?>
						</div>

						<div class="tabs-container">
							<ul class="tabs-list clearfix">
<?php
								$n = 0;
								foreach ( $posts[ 'data' ] as $data ) :
									$child = $data[ 'child' ];
									$query = $data[ 'query' ];

									if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
										$post_id = get_the_id();

										$icon_name = '';
										$label = '';
										$meta_key = Helper::get_post_meta_key( __CLASS__, $query );
										$opts = get_post_meta( $post_id, $meta_key, true );

										if ( is_array( $opts ) ) {
											if ( array_key_exists( 'icon', $opts )	 ) {
												$icon_name = $opts[ 'icon' ];
											}
											if ( array_key_exists( 'label', $opts )	 ) {
												$label = $opts[ 'label' ];
											}
										}

										$anchor = $this->prepareAnchor( $label );
										$active = ! $n++ ? ' active' : '';
?>
											<li class="fa fa-<?php echo esc_attr( $icon_name ); ?><?php echo $active; ?>">
												<a href="#<?php echo esc_attr( $anchor ); ?>">
													<?php _e( $label, $this->lang_domain ); ?>
												</a>
											</li>
<?php
										endwhile;
									endif;
								endforeach;
?>
							</ul>
							<div class="tabs-content">
								<div class="container">
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
										</div>
									</div>
								</div>
							</div> <!-- .tabs-content -->
						</div> <!-- .tabs-container -->

					</div> <!-- .features-inner-wrap -->
				</div> <!-- .features-wrap -->
			</section> <!-- .briz-features-tmpl -->
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
			$n = 0;
			foreach ( $posts[ 'data' ] as $data ) :
				$child = $data[ 'child' ];
				$query = $data[ 'query' ];

				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
					$post_id = get_the_id();

					$label = '';
					$meta_key = Helper::get_post_meta_key( __CLASS__, $query );
					$opts = get_post_meta( $post_id, $meta_key, true );

					if (
						is_array( $opts ) &&
						array_key_exists( 'label', $opts )
					) {
							$label = $opts[ 'label' ];
					}

					$anchor = $this->prepareAnchor( $label );
					$active = ! $n++ ? 'active' : '';
?>
					<div class="tab-content-inner <?php echo $active; ?>" id="<?php echo esc_attr( $anchor ); ?>">
						<div class="tab-content-text">
							<img
								src="<?php echo esc_attr( get_the_post_thumbnail_url( $post_id, 'full' ) ); ?>"
								alt="<?php echo esc_attr( get_the_title() ); ?>"
								title="<?php echo esc_attr( get_the_title() ); ?>"
							/>
							<?php the_title( '<h3>', '</h3>'); ?>
							<?php the_content( __( 'Explore', $this->lang_domain ) ); ?>
						</div>
					</div>
<?php
				endwhile;
				wp_reset_postdata();
				endif;
			endforeach;
		}
	}
