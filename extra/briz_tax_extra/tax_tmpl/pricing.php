<?php
	namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl;
	use Briz_Shortcodes\common\Helper;

	/**
	 * Pricing template.
	 *
	 * Формирование вывода шаблона "pricing".
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
	class Pricing {
		private $tmpl_name = 'briz-pricing-tmpl';
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
			$trigger_bg_color = '';
			$content_bg_color = '';
			$content_width_class = 'container';
			$trigger = false;
			$period_name_first = '';
			$period_name_last = '';

			if ( is_array( $opts ) ) {
				if ( array_key_exists( 'header', $opts ) ) {
					$header = $opts[ 'header' ] ? true : $header;
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
					! empty( $opts[ 'trigger_bg_color_enable' ] ) &&
					array_key_exists( 'trigger_bg_color_enable', $opts ) &&
					array_key_exists( 'trigger_bg_color', $opts )
				) {
					$trigger_bg_color = 'background-color: ' . esc_attr( $opts[ 'trigger_bg_color' ] ) . ';';
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

				if ( array_key_exists( 'trigger', $opts ) ) {
					$trigger = $opts[ 'trigger' ] ? true : $trigger;
				}

				if ( array_key_exists( 'period_name_first', $opts ) ) {
					$period_name_first = __( $opts[ 'period_name_first' ], $this->lang_domain );
				}

				if ( array_key_exists( 'period_name_last', $opts ) ) {
					$period_name_last = __( $opts[ 'period_name_last' ], $this->lang_domain );
				}

				if ( $header || $trigger ) {
					$section_class = 'section-with-header';
				}

				if ( array_key_exists( 'items_per_row', $opts ) ) {
					$items_per_row = absint( $opts[ 'items_per_row' ] );
					if ( $items_per_row < 2 )
						$items_per_row = 2;
					elseif ( $items_per_row > 4 )
						$items_per_row = 4;
				}
			}
?>
			<section
				id="<?php echo esc_attr( $this->id ); ?>"
				class="showcase section pricing-page
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
				if ( $trigger && $period_name_first &&  $period_name_last ) :
?>
					<div
						class="section-trigger-wrap"
						style="<?php echo $trigger_bg_color; ?>"
					>
						<div class="container">
							<div class="row">
								<div class="col-sm-12">
									<div class="price-period-trigger" >
										<div class="trigger-period-name active">
											<?php echo $period_name_first; ?>
										</div>
										<div class="price-trigger-tumbler-outer active" data-trigger=".pricing-body-price">
											<div class="price-trigger-tumbler-inner"></div>
										</div>
										<div class="trigger-period-name">
											<?php echo $period_name_last; ?>
										</div>
									</div>
								</div> <!-- .col-sm-12 -->
							</div> <!-- .row -->
						</div> <!-- .container -->
					</div> <!-- .section-trigger-wrap -->
<?php
				endif;
?>
					<!-- <div class="section-content-wrap" style="background-image: url(./images/pricing/pricing-3.png)"> -->
					<div
						class="section-content-wrap <?php echo esc_attr( $attachment ); ?>"
						style="<?php echo esc_attr( $bg ), $content_bg_color; ?>"
						data-parallax="<?php echo esc_attr( $parallax_data ); ?>"
						data-image-src="<?php echo esc_attr( $parallax_img_src ); ?>"
						data-shortcode-term-id="<?php echo esc_attr( $this->curr_term_id ); ?>"
					>
						<div class="<?php echo $content_width_class; ?>">
							<div class="row">
								<div class="cols-<?php echo $items_per_row; ?> col-sm-12 section-content-inner-wrap">
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
							</div> <!-- .col-sm-12 -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div> <!-- .section-content-wrap -->
			</section> <!-- .briz-pricing-tmpl -->
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
			$placeholder = PLUGIN_URL . '/img/placeholder/pricing/placeholder.png';
			foreach ( $posts[ 'data' ] as $data ) :
				$query = $data[ 'query' ];

				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
					$post_id = get_the_id();

					$meta_key = Helper::get_post_meta_key( __CLASS__, $query );
					$opts = get_post_meta( $post_id, $meta_key, true );

					$best_price = false;
					$best_price_text = 'Best price';
					$best_price_text_color = '#ffffff';
					$best_price_bg_color = '#cc0000';
					$header = '';
					$description = '';
					$currency = '';
					$price_first = 0;
					$price_last = 0;
					$period_first = '';
					$period_last = '';
					$content = '';

					if ( is_array( $opts ) ) {
						if ( array_key_exists( 'best_price', $opts ) )
							$best_price = $opts[ 'best_price' ] ? true : $best_price;

						if ( array_key_exists( 'best_price_text', $opts ) )
							$best_price_text = __( $opts[ 'best_price_text' ], $this->lang_domain );

						if ( array_key_exists( 'best_price_text_color', $opts ) )
							$best_price_text_color = esc_attr( $opts[ 'best_price_text_color' ] );

						if ( array_key_exists( 'best_price_bg_color', $opts ) )
							$best_price_bg_color = esc_attr( $opts[ 'best_price_bg_color' ] );

						if ( array_key_exists( 'header', $opts ) )
							$header = __( $opts[ 'header' ], $this->lang_domain );

						if ( array_key_exists( 'description', $opts ) )
							$description = __( $opts[ 'description' ], $this->lang_domain );

						if ( array_key_exists( 'currency', $opts ) )
							$currency = __( $opts[ 'currency' ], $this->lang_domain );

						if ( array_key_exists( 'price_first', $opts ) )
							$price_first = $opts[ 'price_first' ];

						if ( array_key_exists( 'price_last', $opts ) )
							$price_last = $opts[ 'price_last' ];

						if ( array_key_exists( 'period_first', $opts ) )
							$period_first = __( $opts[ 'period_first' ], $this->lang_domain );

						if ( array_key_exists( 'period_last', $opts ) )
							$period_last = __( $opts[ 'period_last' ], $this->lang_domain );

						if ( array_key_exists( 'content', $opts ) )
							$content = __( $opts[ 'content' ], $this->lang_domain );
					}

					$post_link = esc_url( get_permalink() );
					$post_more_link_text = __( 'Readmore...', $this->lang_domain );
					$best_price_style = "color:$best_price_text_color; background-color:$best_price_bg_color;";
	?>
					<div class="section-item-wrap">
						<div class="section-item-inner">
<?php
							if ( $best_price ) :
?>
								<div class="best-price">
									<span style="<?php echo $best_price_style; ?>">
										<?php echo $best_price_text; ?>
									</span>
								</div>
<?php
							endif;
?>
							<div class="price-caption">
								<h3><?php echo $header; ?></h3>
								<p><?php echo $description; ?></p>
							</div>
							<div class="price-body">
								<div class="pricing-body-price active">
									<span class="price-currency"><?php echo $currency; ?></span>
									<span class="price-number"><?php echo $price_first; ?></span>
									<span class="price-period">\<?php echo $period_first; ?></span>
								</div>
								<div class="pricing-body-price">
									<span class="price-currency"><?php echo $currency; ?></span>
									<span class="price-number"><?php echo $price_last; ?></span>
									<span class="price-period">\<?php echo $period_last; ?></span>
								</div>
								<div class="price-features">
									<?php echo $content; ?>
								</div>
							</div>
							<div class="pricing-link">
								<a href="<?php echo $post_link; ?>">
									<?php echo $post_more_link_text; ?>
								</a>
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
