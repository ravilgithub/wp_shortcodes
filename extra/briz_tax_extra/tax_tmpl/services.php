<?php
namespace Briz_Shortcodes;

/**
 * Services template.
 *
 * Формирование вывода шаблона "services".
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
class Services {
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
		wp_enqueue_style( 'services-tmpl-css' );
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
			class="briz-services-tmpl showcase section services-page <?php echo $class ?>"
			data-shortcode-term-id="<?php echo esc_attr( $this->curr_term_id ); ?>"
		>
			<div class="container">
				<div class="row">
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
?>
				</div> <!-- .row -->
			</div> <!-- .container -->
		</section> <!-- .briz-services-tmpl -->
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

		if ( empty( $posts[ 'data' ] ) ) {
			return;
		}

		foreach ( $posts[ 'data' ] as $data ) :
			$child = $data[ 'child' ];
			$query = $data[ 'query' ];

			// Helper::debug( $query );
			// Helper::debug( $child );

			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
				$post_id = get_the_id();
				$icon_name = get_post_meta( $post_id, '_category_services_icon', true );
?>
				<div
					class="col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-0 services-item-wrap <?php echo esc_attr( $child->slug ); ?>"
					data-post-id="<?php echo esc_attr( $post_id ); ?>"
				>
					<div class="icon-wrap">
			<?php if ( $icon_name ) : ?>
							<i
								class="fa fa-<?php echo esc_attr( $icon_name ); ?>"
								aria-hidden="true"
							></i>
			<?php endif; ?>
					</div> <!-- .icon-wrap -->

					<div class="content-wrap">
						<h4>
							<?php echo esc_attr( get_the_title() ); ?>
						</h4>
						<p><?php echo get_the_excerpt(); ?></p>
						<a href="<?php esc_attr( the_permalink() ); ?>">Read more</a>
					</div> <!-- .content-wrap -->
				</div> <!-- .services-item-wrap -->
<?php
			endwhile;
			wp_reset_postdata();
			endif;
		endforeach;
	}
}
