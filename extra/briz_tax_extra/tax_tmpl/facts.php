<?php
	namespace Briz_Shortcodes;

	/**
	 * Facts template.
	 *
	 * Формирование вывода шаблона "facts".
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
	class Facts {
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
		 * @param String $id            - id <?php echo esc_attr( $this->id ); ?>.
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
			wp_enqueue_style( 'briz-facts-tmpl-css' );
			wp_enqueue_script( 'briz-facts-tmpl-js' );
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
			$bg_img = '';
			$img_id = ( int ) get_term_meta( $term_id, 'briz-term-img-id', true );

			if ( $img_id ) {
				$img_url = wp_get_attachment_image_url( $img_id, 'full' );
				$bg_img = 'background-image: url(' . $img_url . ')';
			}
?>
			<!-- Fixed Background -->
			<section
				id="<?php echo esc_attr( $this->id ); ?>"
				class="briz-facts-tmpl section facts-page <?php echo $class ?>"
				style="<?php echo esc_attr( $bg_img ); ?>"
				data-shortcode-term-id="<?php echo esc_attr( $this->curr_term_id ); ?>"
			>

			<!-- Parallax Background -->
			<!-- <section
				id="<?php // echo esc_attr( $this->id ); ?>"
				class="briz-facts-tmpl section facts-page parallax-window <?php // echo $class ?>"
				data-parallax="scroll"
				data-image-src="<?php // echo esc_attr( $img_url ); ?>"
				data-shortcode-term-id="<?php // echo esc_attr( $this->curr_term_id ); ?>"
			> -->

				<div class="facts-inner-wrap">
					<div class="container">
						<div class="row">
							<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
								<div class="section-caption">
									<h2>Some facts <span>about us</span></h2>
									<div class="spacer">
										<div class="diamond"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row facts-items-wrap">
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
						</div> <!-- .facts-items-wrap -->
					</div> <!-- .container -->
				</div> <!-- .facts-inner-wrap -->
			</section> <!-- .briz-facts-tmpl -->
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
			if ( empty( $posts[ 'data' ] ) )
				return;

			foreach ( $posts[ 'data' ] as $data ) :
				$child = $data[ 'child' ];
				$query = $data[ 'query' ];
				$tax_name = $query->query[ 'tax_query' ][ 0 ][ 'taxonomy' ];
				$class_name = explode( '\\', __CLASS__ );
				$class_name = strtolower( array_pop( $class_name ) );
				$meta_key = '_' . $tax_name . '_' . $class_name;

				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
					$post_id = get_the_id();
					$post_meta_vals = get_post_meta( $post_id, $meta_key )[ 0 ];

					foreach ( $post_meta_vals as $vals ) :
						extract( $vals );
?>
						<div class="col-sm-3 facts-item">
							<div class="facts-item-inner">
								<div>
									<i class="fa fa-<?php echo esc_attr( $icon ); ?>"></i>
									<span
										class="progress-num"
										data-number="<?php echo esc_attr( $number ); ?>"
										data-symbol="<?php echo esc_attr( $symbol ); ?>"
										data-symbol-position="<?php echo esc_attr( $symbol_position ); ?>"
									>0</span>
								</div>
								<p><?php echo $label; ?></p>
							</div>
						</div>
<?php
					endforeach;
				endwhile;
				wp_reset_postdata();
				endif;
			endforeach;
		}
	}
