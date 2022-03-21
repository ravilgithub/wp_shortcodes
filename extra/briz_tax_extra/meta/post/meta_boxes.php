<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\meta\post;
use Briz_Shortcodes\extra\briz_tax_extra\meta\Meta;
use Briz_Shortcodes\common\Helper;

/**
 * The class adds meta boxes for posts.
 *
 * Класс добавляет метабоксы для записей.
 *
 * @property Array $screens    - типы записей к которым допустимо добавлять метаблок.
 * @property Array $taxs       - таксономии к записям которых добавляются метабоксы.
 * @property String $id_prefix - префикс идентификатора метабокса и его полей.
 * @property Array $opts       - параметры полей по умолчанию.
 *
 * @since 0.0.1
 * @author Ravil
 */
class Meta_Boxes extends Meta {
	public $screens;
	public $taxs;
	public $id_prefix = 'briz_meta_box';
	public $opts      = [];
	private $is_group = false;


	/**
	 * Constructor
	 *
	 * @param Array $screens - типы записей к которым допустимо добавлять метаблок.
	 * @param Array $taxs    - таксономии к записям которых добавляются метабоксы.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function __construct( $screens, $taxs ) {
		$this->taxs = $taxs;
		$this->screens = $screens;

		parent::__construct();

		require_once( PLUGIN_PATH . 'extra/briz_tax_extra/meta/post/opts.php' );
		$this->opts = apply_filters( "{$this->id_prefix}_opts", $opts );

		add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ], 10, 2 );
		add_action( 'save_post', [ $this, 'meta_box_save' ], 1, 2 );
	}


	/**
	 * Collection of template names according to which the output of term posts is formed,
	 * including the names of templates of parent terms, if any.
	 *
	 * Сбор имён шаблонов согласно которым формируется вывод записей терминов,
	 * в том числе имена шаблонов родительских терминов если они есть.
	 *
	 * @param Object $post - Объект записи: объект WP_Post.
	 *
	 * @return Array $term_info {
	 *   @type Array $tmpl - массив имён шаблонов.
	 *   @type String $taxonomy - имя таксономии к которой относятся термины.
	 * }
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function get_terms_info( $post ) {
		$taxs = get_object_taxonomies( $post );
		$term_info = [];

		foreach ( $taxs as $tax ) {
			if ( in_array( $tax, $this->taxs ) ) {
				$term_info[ 'tmpl' ] = [];
				$term_info[ 'taxonomy' ] = $tax;
				$terms = get_the_terms( $post->ID, $tax );

				if ( ! empty( $terms ) ) {
					foreach ( $terms as $k => $term ) {
						$term_id = $term->term_id;
						// $term_info[ $k ][ 'taxonomy' ] = $tax;
						// $term_info[ $k ][ 'term_id' ] = $term_id;

						do {
							$tmpl_path = get_term_meta( $term_id, 'tmpl', $tax );

							if ( '' !== $tmpl_path && -1 != $tmpl_path ) {
								$tmpl_info = pathinfo( $tmpl_path );
								$tmpl_name = $tmpl_info[ 'filename' ];

								if ( ! in_array( $tmpl_name, $term_info[ 'tmpl' ] ) ) {
									$term_info[ 'tmpl' ][] = $tmpl_name;
								}
								// $term_info[ $k ][ 'tmpl' ][ $term_id ] = $tmpl_info[ 'filename' ];
							}

							$curent_term = get_term_by( 'id', $term_id, $tax );
							$term_id = $curent_term->parent;
						} while ( $term_id );
					}
				}
			}
		}

		return $term_info;
	}


	/**
	 * Collecting data for the formation of the metabox.
	 *
	 * Сбор данных для формирования метабокса.
	 *
	 * @param String $post_type - Название типа записи, на странице редактирования которой вызывается хук.
	 * @param Object $post - Объект записи: объект WP_Post.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function add_meta_box( $post_type, $post ) {
		$callback = [ $this, 'meta_box' ];
		$terms_info = $this->get_terms_info( $post );

		/**
		 * Добавляем метаблок только указанным типам записи.
		 */
		if ( ! in_array( $post_type, $this->screens ) ) {
			return;
		}

		$n = 0;
		foreach ( $terms_info[ 'tmpl' ] as $tmpl ) {
			$n++;
			$title = __( "Options for term template: ", $this->lang_domain ) . ucfirst( $tmpl );

			$tax = $terms_info[ 'taxonomy' ];

			if (
				! array_key_exists( $tax, $this->opts ) ||
				! array_key_exists( $tmpl, $this->opts[ $tax ] ) ||
				empty( $this->opts[ $tax ][ $tmpl ][ 'fields' ] )
			) {
				continue;
			}

			$callback_args[ 'fields' ] = $this->opts[ $tax ][ $tmpl ][ 'fields' ];
			$callback_args[ 'taxonomy' ] = $tax;
			$callback_args[ 'tmpl' ] = $tmpl;

			$callback_args[ 'page' ] = 'post';
			$callback_args[ 'action' ] = 'edit';
			$callback_args[ 'id' ] = $post->ID;
			$callback_args[ 'wp_object' ] = $post;

			$meta_box_id = "{$this->id_prefix}_{$n}";
			$callback_args[ 'meta_box_id' ] = $meta_box_id;

			add_meta_box( $meta_box_id, $title, $callback, $this->screens, 'advanced', 'default', $callback_args );
		}
	}


	/**
	 * HTML output meta box content.
	 *
	 * Вывод HTML содержание метабокса.
	 *
	 * @param Object $post - Объект записи: объект WP_Post.
	 * @param Array $meta - данные поста (объект $post) и аргументы переданные в этот параметр.
	 *   @see add_meta_box( ...$callback_args )
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function meta_box( $post, $meta ) {
?>
		<div class="briz_meta_box_wrap">
			<table width="100%">
				<thead>
				<tr>
					<th><?php _e( 'Name', $this->lang_domain ); ?></th>
					<th><?php _e( 'Value', $this->lang_domain ); ?></th>
				</tr>
				</thead>
				<tbody>
					<?php
						$this->fields_iterator( $meta[ 'args' ] );
					?>
					<tr>
						<td colspan="2" class="briz-meta-reset-all-btn-cell">
							<button
								type="button"
								class="button briz-meta-reset-all"
								data-meta-box-id="<?php echo esc_attr( $meta[ 'args' ][ 'meta_box_id' ] ); ?>"
							><?php _e( 'Reset all', $this->lang_domain ); ?></button>
						</td>
					</tr>
					<tr class="briz-hidden">
						<td colspan="2">
							<?php wp_nonce_field( 'name_of_my_action','name_of_nonce_field' ); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
<?php
	}


	/**
	 * Saving, changing or deleting the values of the meta fields of the posts.
	 *
	 * Сохранение, изменение или удаление значений мета полей записи.
	 *
	 * @param String $post_id - ID записи, которая обновляется.
	 * @param Object $post - Объект записи: объект WP_Post.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function meta_box_save( $post_id, $post ) {
		if (
			! isset( $_POST[ 'name_of_nonce_field' ] ) ||
			! wp_verify_nonce( $_POST[ 'name_of_nonce_field' ], 'name_of_my_action' )
		) return;

		if (
			! current_user_can( 'edit_post', $post_id ) ||
			! current_user_can( 'edit_page', $post_id )
		) return;

		if ( ! isset( $_POST[ $this->id_prefix ] ) )
			return;

		foreach ( $_POST[ $this->id_prefix ] as $key => $val ) {
			if ( ! $val && $val !== '0' ) {
				delete_post_meta( $post_id, $key );
			} else {
				update_post_meta( $post_id, $key, $val );
			}
		}
	}
}


/**
 * Initializing Class Meta_Boxes.
 *
 * Инициализация класса Meta_Boxes.
 *
 * @return void
 *
 * @since 0.0.1
 * @author Ravil
 */
function meta_boxes_init() {
	$atts = [
		'screens'    => [ 'post', 'product' ],
		'taxonomies' => [ 'category', 'product_cat' ]
	];

	$atts = apply_filters( 'BRIZ_Meta_Boxes_Atts', $atts );

	if ( empty( $atts ) )
		return;

	extract( $atts );
	$meta_boxes = new Meta_Boxes( $screens, $taxonomies );
}

add_action( 'admin_init', __NAMESPACE__ . '\\meta_boxes_init' );
