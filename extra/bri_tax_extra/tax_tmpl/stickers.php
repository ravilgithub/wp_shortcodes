<?php
	namespace Bri_Shortcodes;

	/**
	 * Stickers template.
	 *
	 * Формирование вывода шаблона "stickers".
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
	class Stickers {
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
			wp_enqueue_style( 'stickers-tmpl-css' );
			wp_enqueue_script( 'stickers-tmpl-js' );
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
			// Helper::debug( $posts );
			extract( $this->atts );

			$bg_img = '';
			$img_id = ( int ) get_term_meta( $term_id, 'briz-term-img-id', true );
			if ( $img_id ) {
				$img_url = wp_get_attachment_image_url( $img_id, 'full' );
				$bg_img = 'background-image: url(' . $img_url . ')';
			}
?>
			<section
				id="<?php echo esc_attr( $this->id ); ?>"
				class="bri-stickers-tmpl showcase section stickers-page <?php echo $class ?>"
				data-shortcode-term-id="<?php echo esc_attr( $this->curr_term_id ); ?>"
			>
				<div class="stickers-wrap">
					<div class="stickers-inner-wrap">
						<div class="stickers-content clearfix" style="<?php echo esc_attr( $bg_img ); ?>"> <!-- Fixed -->
							<div class="container">
								<div class="row">
									<div class="stickers-content-grid col-sm-12">
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
									</div> <!-- .stickers-content-grid -->
								</div> <!-- .row -->
							</div> <!-- .container -->
						</div> <!-- .stickers-content -->
					</div> <!-- .stickers-inner-wrap -->
				</div> <!-- .stickers-wrap -->
			</section> <!-- .bri-stickers-tmpl -->
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

				// Helper::debug( $child );
				// Helper::debug( $query );

				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
					$post_id = get_the_id();

					$style = '';
					if ( has_post_thumbnail( $post_id ) ) {
						$style = 'background-image: url(' .  get_the_post_thumbnail_url( $post_id, 'full' ) . ')';
					}
?>
					<div class="stickers-content-item">
						<div class="stickers-content-item-inner" style="<?php echo esc_attr( $style ); ?>">
							<?php the_title( '<h3>', '</h3>'); ?>
							<?php the_content( __( 'Readmore...', $this->lang_domain ) ); ?>
						</div>
					</div>
<?php
				endwhile;
				wp_reset_postdata();
				endif;
			endforeach;
		}
	}
