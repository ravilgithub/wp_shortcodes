<?php
	namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl;
	use Briz_Shortcodes\inc\Briz_Tax_Shortcode;
	use Briz_Shortcodes\common\Helper;

	/**
	 * Portfolio template.
	 *
	 * Формирование вывода шаблона "portfolio".
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
	class Portfolio {
		private $tmpl_name = 'briz-portfolio-tmpl';
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
			$tab_bg_color = '';
			$content_bg_color = '';
			$content_width_class = 'container';

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
				class="showcase section portfolio-page
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
				$show_all_text = __( 'All', $this->lang_domain );
?>
				<div
					class="section-tabs-wrap"
					style="<?php echo $tab_bg_color; ?>"
				>
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<ul class="isotop-filter">
									<li class="active" data-term-id="-1">
										<a href="#"><?php echo $show_all_text; ?></a>
									</li>
<?php
								foreach ( $childrens as $child ) :
									$this->all_posts_count += $child->count;
									$term_id = esc_attr( $child->term_id );
									$term_posts_count = esc_attr( $child->count );
									$term_slug = esc_attr( $child->slug );
									$term_name = __( $child->name, $this->lang_domain );
?>
									<li
										data-term-id="<?php echo $term_id; ?>"
										data-term-posts-count="<?php echo $term_posts_count; ?>"
									>
										<a href="#<?php echo $term_slug; ?>"><?php echo $term_name; ?></a>
									</li>
<?php
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
								<div class="isotope js-gallery">
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
								</div> <!-- .isotope.js-gallery -->
<?php
							if ( $show_more && -1 !== $limit && ( $limit < $this->all_posts_count - $offset ) ) :
								$shortcode_id = esc_attr( $this->id );
								$all_posts_count = esc_attr( $this->all_posts_count );
								$show_more_text = __( 'Show more', $this->lang_domain );
?>
								<div class="showmore-wrap">
									<button
										class="showmore"
										data-shortcode-id="<?php echo $shortcode_id; ?>"
										data-all-posts-count="<?php echo $all_posts_count; ?>"
									><?php echo $show_more_text; ?></button>
								</div> <!-- .showmore-wrap -->
<?php
							endif;
?>
							</div> <!-- .col-sm-12 -->
						</div> <!-- .row -->
					</div> <!-- .container [ -fluid ] -->
				</div> <!-- .section-content-wrap -->
			</section> <!-- .briz-portfolio-tmpl -->
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
			foreach ( $posts[ 'data' ] as $data ) :
				$child = $data[ 'child' ];
				$query = $data[ 'query' ];

				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
					$post_id = get_the_id();
					$post_title = esc_attr__( get_the_title(), $this->lang_domain );
					$post_link = esc_attr( get_the_permalink() );
					$term_slug = esc_attr( $child->slug );
					$post_thumb_url = esc_url( get_the_post_thumbnail_url( $query->ID, 'full' ) );
	?>
					<div
						class="isotope-item <?php echo $term_slug; ?>"
						data-post-id="<?php echo $post_id; ?>"
					>
						<figure class="showcase-item">
							<div class="showcase-item-thumbnail">
								<img src="<?php echo $post_thumb_url; ?>"/>
							</div>

							<figcaption class="showcase-item-hover">
								<a
									href="<?php echo $post_thumb_url; ?>"
									class="portfolio-img-zoom"
								></a>

								<div class="showcase-item-info">
									<div class="showcase-item-title">
										<h6>
											<a
												href="<?php echo $post_link; ?>"
												class="portfolio-post-link"
											><?php echo $post_title; ?></a>
										</h6>
									</div>

									<div class="showcase-item-category">
										<ul>
	<?php
										$post_terms = get_the_terms( $query->ID, $child->taxonomy );

										if ( is_array( $post_terms ) ) :
											foreach ( $post_terms as $post_term ) :
												$term_link = esc_attr( get_term_link( $post_term ) );
												$term_name = __( $post_term->name, $this->lang_domain );
	?>
												<li>
													<a
														href="<?php echo $term_link; ?>"
														class="portfolio-category-link"
													><?php echo $term_name; ?></a>
												</li>
	<?php
											endforeach;
										endif;
	?>
										</ul>
									</div> <!-- .showcase-item-category -->
								</div> <!-- .showcase-item-info -->
							</figcaption> <!-- .showcase-item-hover -->
						</figure> <!-- .showcase-item -->
					</div> <!-- .isotope-item -->

	<?php 
				endwhile;
				wp_reset_postdata();
				endif;
			endforeach;
		}
	}
