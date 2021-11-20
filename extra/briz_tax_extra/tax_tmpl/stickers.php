<?php
	namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl;
	use Briz_Shortcodes\common\Helper;

	/**
	 * Stickers template.
	 *
	 * Формирование вывода шаблона "stickers".
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
	class Stickers {
		private $tmpl_name = 'briz-stickers-tmpl';
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

			$bg = '';
			$add_class = '';
			$parallax_data = '';
			$parallax_img_src = '';
			$term_opts = get_term_meta( $term_id, 'briz_term_meta', true );

			if ( is_array( $term_opts ) ) {
				if ( array_key_exists( 'stickers_background', $term_opts ) ) {
					$bg_type = $term_opts[ 'stickers_background' ];

					if (
						'hidden' != $bg_type &&
						array_key_exists( 'option_11', $term_opts ) &&
						$img_id = ( int ) $term_opts[ 'option_11' ]
					) {
						if ( $img_url = wp_get_attachment_image_url( $img_id, 'full' ) ) {
							if ( 'fixed' == $bg_type || 'default' == $bg_type ) {
								$bg = 'background-image: url(' . $img_url . ')';
								if ( 'fixed' == $bg_type ) {
									$add_class = 'bg-fixed';
								}
							} else {
								$add_class = 'parallax-window';
								$parallax_data = 'scroll';
								$parallax_img_src = $img_url;
							}
						}
					}
				}
			}
?>
			<section
				id="<?php echo esc_attr( $this->id ); ?>"
				class="<?php echo esc_attr( $this->tmpl_name ); ?> showcase section stickers-page <?php echo $class ?>"
				data-shortcode-term-id="<?php echo esc_attr( $this->curr_term_id ); ?>"
			>
				<div class="stickers-wrap">
					<div class="stickers-inner-wrap">
						<div
							class="stickers-content clearfix <?php echo esc_attr( $add_class ); ?>"
							style="<?php echo esc_attr( $bg ); ?>"
							data-parallax="<?php echo esc_attr( $parallax_data ); ?>"
							data-image-src="<?php echo esc_attr( $parallax_img_src ); ?>"
						>
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
			</section> <!-- .briz-stickers-tmpl -->
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

					$style = '';
					$bg_only_class = '';
					if ( has_post_thumbnail( $post_id ) ) {
						$style = 'background-image: url(' .  get_the_post_thumbnail_url( $post_id, 'full' ) . ')';

						$sticker_opts = get_post_meta( $post_id, '_category_stickers', true );
						if ( ! empty( $sticker_opts[ 'bg_only' ] ) && is_array( $sticker_opts[ 'bg_only' ] ) && !! $sticker_opts[ 'bg_only' ][ 0 ] ) {
							$bg_only_class = 'empty';
						}
					}
?>
					<div class="stickers-content-item <?php echo esc_attr( $bg_only_class ); ?>">
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
