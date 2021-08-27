<?php
	namespace Briz_Shortcodes;

	/**
	 * Portfolio template.
	 *
	 * Формирование вывода шаблона "portfolio".
	 *
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
			wp_enqueue_style( 'briz-portfolio-tmpl-css' );
			wp_enqueue_script( 'briz-portfolio-tmpl-js' );
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
			// Helper::debug( $this->atts );
			extract( $this->atts );
?>
			<section
				id="<?php echo esc_attr( $this->id ); ?>"
				class="briz-portfolio-tmpl showcase section portfolio-page <?php echo $class ?>"
				data-shortcode-term-id="<?php echo esc_attr( $this->curr_term_id ); ?>"
			>
				<div class="section-inner-wrap">
					<div class="section-content">
			<?php

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

			// Helper::debug( $childrens, '200px' );

			if ( $children || $grandchildren ) :?>
				<div class="isotop-filter-wrap">
					<ul class="filter clearfix">
						<li class="active" data-term-id="-1">
							<a href="#">all</a>
						</li>
			<?php foreach ( $childrens as $child ) :
							$this->all_posts_count += $child->count;
			?>
							<li
								data-term-id="<?php echo esc_attr( $child->term_id ); ?>"
								data-term-posts-count="<?php echo esc_attr( $child->count ); ?>"
							>
								<a href="#<?php echo esc_attr( $child->slug ); ?>"><?php echo $child->name; ?></a>
							</li>
			<?php endforeach; ?>
					</ul> <!-- .filter.clearfix -->
				</div> <!-- .isotop-filter-wrap -->

		<?php 
			else :
				$this->all_posts_count = $childrens[ 0 ]->count;
			endif;
		?>

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

			<?php if ( $show_more && -1 !== $limit && ( $limit < $this->all_posts_count - $offset ) ) : ?>
						<div class="show-more-wrap">
							<button
								class="show-more"
								data-shortcode-id="<?php echo esc_attr( $this->id ); ?>"
								data-all-posts-count="<?php echo esc_attr( $this->all_posts_count ); ?>"
							><?php _e( 'Show More', $this->lang_domain ); ?></button>
						</div> <!-- .show-more-wrap -->
			<?php endif; ?>

					</div> <!-- .section-content -->
				</div> <!-- .section-inner-wrap -->
			</section>
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
			// Helper::debug( $posts );
			foreach ( $posts[ 'data' ] as $data ) :
				$child = $data[ 'child' ];
				$query = $data[ 'query' ];

				// Helper::debug( $query );
				// Helper::debug( $child );

				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
					$post_id = get_the_id();

					if ( 515 === $post_id ) {
						// echo '<br />option 1 - ' . get_post_meta( $post_id, '_category_portfolio_option_1', true );
						// echo '<br />option 2 - ' . get_post_meta( $post_id, '_category_portfolio_option_2', true );
						// echo '<br />option 3 - ' . get_post_meta( $post_id, '_category_portfolio_option_3', true );
						// echo '<br />option 4 - ' . get_post_meta( $post_id, '_category_portfolio_option_4', true );
						// echo '<br />option 5 - ' . get_post_meta( $post_id, '_category_portfolio_option_5', true );

						// echo '<br />option 6 - ';
						// print_r( get_post_meta( $post_id, '_category_portfolio_option_6', true ) );
					}

	?>
					<div
						class="isotope-item <?php echo esc_attr( $child->slug ); ?>"
						data-post-id="<?php echo esc_attr( $post_id ); ?>"
					>
						<figure class="showcase-item">
							<div class="showcase-item-thumbnail">
								<img
									src="<?php echo esc_attr( get_the_post_thumbnail_url( $query->ID, 'full' ) ); ?>"
									alt="<?php echo esc_attr( get_the_title() ); ?>"
									title="<?php echo esc_attr( get_the_title() ); ?>"
								/>
							</div> <!-- .showcase-item-thumbnail -->

							<figcaption class="showcase-item-hover">
								<a
									href="<?php echo esc_attr( get_the_post_thumbnail_url( $query->ID ), 'full' ); ?>"
									class="portfolio-img-zoom"
									title="<?php echo esc_attr( get_the_title() ); ?>"
								></a> <!-- .portfolio-img-zoom -->

								<div class="showcase-item-info">
									<div class="showcase-item-title">
										<h6>
											<a
												href="<?php esc_attr( the_permalink() ); ?>"
												class="portfolio-post-link"
											><?php echo get_the_title(); ?></a> <!-- .portfolio-post-link -->
										</h6>
									</div> <!-- .showcase-item-title -->

									<div class="showcase-item-category">
										<ul>

	<?php
										$post_terms = get_the_terms( $query->ID, $child->taxonomy );
										if ( is_array( $post_terms ) ) :
											foreach ( $post_terms as $post_term ) :
	?>
												<li>
													<a
														href="<?php echo esc_attr( get_term_link( $post_term ) ); ?>"
														class="portfolio-category-link"
													><?php echo $post_term->name; ?></a>
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
					</div>

	<?php 
				endwhile;
				wp_reset_postdata();
				endif;
			endforeach;
		}
	}
