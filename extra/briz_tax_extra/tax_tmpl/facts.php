<?php
	namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl;
	use Briz_Shortcodes\common\Helper;

	/**
	 * Facts template.
	 *
	 * Формирование вывода шаблона "facts".
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
	class Facts {
		private $tmpl_name = 'briz-facts-tmpl';
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
				class="showcase section facts-page
					<?php echo esc_attr( $this->tmpl_name ); ?>
					<?php echo esc_attr( $class ); ?>
					<?php echo esc_attr( $section_class ); ?>"
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
					<div class="<?php echo $content_width_class; ?>">
						<div class="row">
							<div class="facts-items-wrap">
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
						</div> <!-- .row -->
					</div> <!-- .container [ -fluid ] -->
				</div> <!-- .section-content-wrap -->
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

				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
					$post_id = get_the_id();
					$meta_key = Helper::get_post_meta_key( __CLASS__, $query );
					$opts = get_post_meta( $post_id, $meta_key, true );

					foreach ( $opts as $opt ) :
						$icon = '';
						$number = 0;
						$symbol = '';
						$symbol_position = '';
						$label = '';

						if ( array_key_exists( 'icon', $opt ) )
							$icon = ( ! empty( $opt[ 'icon' ] ) ) ? esc_attr( $opt[ 'icon' ] ) : $icon;

						if ( array_key_exists( 'number', $opt ) )
							$number = ( ! empty( $opt[ 'number' ] ) ) ? esc_attr( $opt[ 'number' ] ) : $number;

						if ( array_key_exists( 'symbol', $opt ) )
							$symbol = ( ! empty( $opt[ 'symbol' ] ) ) ? esc_attr( $opt[ 'symbol' ] ) : $symbol;

						if ( array_key_exists( 'symbol_position', $opt ) )
							$symbol_position = ( ! empty( $opt[ 'symbol_position' ] ) ) ? esc_attr( $opt[ 'symbol_position' ] ) : $symbol_position;

						if ( array_key_exists( 'label', $opt ) )
							$label = ( ! empty( $opt[ 'label' ] ) ) ? __( $opt[ 'label' ], $this->lang_domain  ) : $label;
?>
						<div class="col-sm-3 facts-item">
							<div class="facts-item-inner">
								<div>
									<i class="fa fa-<?php echo $icon; ?>"></i>
									<span
										class="progress-num"
										data-number="<?php echo $number; ?>"
										data-symbol="<?php echo $symbol; ?>"
										data-symbol-position="<?php echo $symbol_position; ?>"
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
