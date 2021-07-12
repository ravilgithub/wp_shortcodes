<?php
namespace Bri_Shortcodes;

/**
 * The class implements the ability to add an image to a term.
 *
 * Класс реализует возможность добавлять изображение термину.
 *
 * @property String $meta_key - имя мета поля термина.
 *
 * @property String $default  - placeholder-изображение применяется в мета полях
 *                              на страницах создания/редактирования термина.
 *
 * @since 0.0.1
 * @author Ravil
 */
class Term_img {
	public $meta_key = 'briz-term-img-id';
	public $default = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAABjElEQVRoge2bWQ6DMAxEe/+z+RAICQ7Bz/SjStWFkM02IcNISFEJ9rwKhawPEcGyLBSXiOARCqNLRLCu6ws4/DCqAtsX8OeNkfTJ9Af8W+Hq+mXZBd6reEXtMUSBYw9cRTHvh8BHD/asI89J4FSA3pTymgWcE6gH5XjMBs4NeJZyvRUBlwT2VImnYuDSBNYq9VIFXJPIQjUeqoFrE2qpNncTcEviFrXkbAZuNeCdSwVYw4hXDjVgwBZaK7YqMGADrRlTHRjQNaj9B5oAAzpGLd4WM2CgzbBVe2AKDNQZt2z8zIGBMgDrz5sLMJAH4vEtdwMGjoG8emuuwMA+mGfX1B0Y+Ab0HnycAgy8QM8Yad3AHqJ6pakaLarPElXHg6prSTV4oBoeUk0AUE3xUE3iUU3TUk3EUy21UC2mUS2XUi2I9wAbZL7loSfYILNNLT3CBqlvW+oZNmiapmSde+thaYAeNc9z9N6w24dj0PcG8VjFqyp5BGAk2KBt295l3mM8I8MGvQ9qhQLDJSJ4AsaVfzhlR3kRAAAAAElFTkSuQmCC';


	/**
	* Constructor.
	*
	* @param Array $taxs - таксономии к терминам которых добавляется
	*                      изображение.
	*
	* @return void.
	*
	* @since 0.0.1
	* @author Ravil
	*/
	public function __construct( Array $taxs ) {
		$this->add_assets();
		$this->add_hooks( $taxs );
	}


	/**
	* Add CSS and JS.
	*
	* Добавление стилей и скриптов.
	*
	* @return void.
	*
	* @since 0.0.1
	* @author Ravil
	*/
	public function add_assets() {
		$assets = [
			'css' => [
				/************ TMPL CSS ************/
				'id'   => 'term-img-css',
				'src'  => PLUGIN_URL . 'extra/bri_tax_extra/assets/css/term_img.min.css',
				'deps' => [],
				'ver'  => '1.0.0'
			],
			'js' => [
				/************ TMPL SCRIPTS ************/
				'id'   => 'term-img-js',
				'src'  => PLUGIN_URL . 'extra/bri_tax_extra/assets/js/term_img.js',
				'deps' => [ 'jquery' ],
				'ver'  => '1.0.0',
				'in_footer' => true
			]
		];

		$assets = apply_filters( 'BRIZ_Term_img_assets', $assets );

		foreach ( $assets as $type => $data ) {
			extract( $data );

			if ( 'css' == $type ) {
				if ( ! wp_style_is( $id, 'enqueued' ) )
					wp_enqueue_style( $id, $src, $deps, $ver );
			} else {
				if ( ! wp_script_is( $id, 'enqueued' ) )
					wp_enqueue_script( $id, $src, $deps, $ver, $in_footer );
			}
		}
	}


	/**
	 * Add hooks to add|change additional fields of taxonomy elements ( terms ).
	 *
	 * Добавляем хуки для добавления|изменения дополнительных полей элементов( терминов ) таксономии.
	 *
	 * @param Array $taxs - массив таксономий к терминам которых будут добавленны дополнительные поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function add_hooks( $taxs ) {
		foreach ( $taxs as $tax_name ) {
			add_action( "{$tax_name}_add_form_fields", [
				$this,
				'add_term_img'
			] );

			add_action( "{$tax_name}_edit_form_fields", [
				$this,
				'edit_term_img'
			] );

			add_action( "created_{$tax_name}", [
				$this,
				'save_term_img'
			] );

			add_action( "edited_{$tax_name}", [
				$this,
				'save_term_img'
			] );

			add_filter( "manage_edit-{$tax_name}_columns", [
				$this,
				'add_img_column'
			] );

			add_filter( "manage_{$tax_name}_custom_column", [
				$this,
				'fill_img_column'
			], 10, 3 );
		}
	}


	/**
	 * Adding additional form fields for taxonomy terms when creating them.
	 *
	 * Добавляем дополнительные поля формы терминов таксономии при их создании.
	 *
	 * @param String $tax_slug - ярлык таксономии.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function add_term_img ( $tax_slug ) {
?>
		<div id="briz-term-img-wrap" class="form-field">
			<label><?php _e( 'Image' ); ?></label>

			<figure>
				<a href="#">
					<img
						src="<?php echo esc_attr( $this->default ); ?>"
						data-default="<?php echo esc_attr( $this->default ); ?>"
						alt="Alt"
					/>
				</a>

				<button type="button" class="button hidden">
					<?php _e( 'Remove' ); ?>
				</button>
			</figure>

			<p><?php _e( 'Description' ); ?></p>

			<input
				type="hidden"
				name="<?php echo esc_attr( $this->meta_key ); ?>"
				value=""
			/>
		</div>
<?php
	}


	/**
	 * Add additional form fields for the taxonomy term on the edit page.
	 *
	 * Добавляем дополнительные поля формы термина таксономи на странице редактирования.
	 *
	 * @param Object $term - WP_Term Object.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function edit_term_img ( $term ) {
		$img_id = ( int ) get_term_meta( $term->term_id, $this->meta_key, true );
		$img_url = $this->default;
		$btn_class = 'hidden';

		if ( $img_id ) {
			$img_url = wp_get_attachment_image_url( $img_id, [ 60, 60 ] );
			$btn_class = '';
		}
?>
		<tr id="briz-term-img-wrap" class="form-field term-image-wrap">
			<th scope="row">
				<label for="description">
					<?php _e( 'Term image' ); ?>
				</label>
			</th>
			<td>
				<figure>
					<a href="#">
						<img
							src="<?php echo esc_attr( $img_url ); ?>"
							data-default="<?php echo esc_attr( $this->default ); ?>"
							alt="Alt"
						/>
					</a>

					<button type="button" class="button <?php echo esc_attr( $btn_class ); ?>">
						<?php _e( 'Remove' ); ?>
					</button>
				</figure>

				<p><?php _e( 'Description' ); ?></p>

				<input
					type="hidden"
					name="<?php echo esc_attr( $this->meta_key ); ?>"
					value="<?php echo esc_attr( $img_id ); ?>"
				/>
			</td>
		</tr>
<?php
	}


	/**
	 * Save changes made to the taxonomy term form.
	 *
	 * Сохраняем изменения внесённые в форму термина таксономии.
	 *
	 * @param Integer $term_id - id сохраняемого термина.
	 *
	 * @return void.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function save_term_img ( $term_id ) {
		if ( ! isset( $_POST[ $this->meta_key ] ) ) return;
		if ( ! current_user_can( 'edit_term', $term_id ) ) return;
		if (
			! wp_verify_nonce( $_POST['_wpnonce'], "update-tag_$term_id" ) &&
			! wp_verify_nonce( $_POST['_wpnonce_add-tag'], 'add-tag' )
		) return;

		$val = ( int ) sanitize_text_field( wp_unslash( $_POST[ $this->meta_key ] ) );

		if ( ! $val )
			delete_term_meta( $term_id, $this->meta_key );
		else
			update_term_meta( $term_id, $this->meta_key, $val );
	}


	/**
	 * Add a column for images to the term table.
	 *
	 * Добавляем колонку для изображений в таблицу терминов.
	 *
	 * @param Array $cols  - параметры колонок таблицы терминов.
	 *
	 * @return Array $cols - параметры колонок таблицы терминов.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function add_img_column ( $cols ) {
		$col_name = __( 'Image' );
		return array_slice( $cols, 0, 2 ) + [ 'briz-col-term-img' => $col_name ] + $cols;
	}


	/**
	 * Add an image or a dash to the image column in the term table.
	 *
	 * Добавляем изображение или прочерк в колонку для изображения в таблице терминов.
	 *
	 * @param String $str      - HTML содержимое ячейки колонки для изображения.
	 * @param String $col_name - имя колонки.
	 * @param Integer $term_id - id термина.
	 *
	 * @return String $str     - HTML содержимое ячейки колонки для изображения.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function fill_img_column ( $str, $col_name, $term_id ) {
		if ( 'briz-col-term-img' === $col_name ) {
			$img_id = ( int ) get_term_meta( $term_id, $this->meta_key, true );

			if ( $img_id ) {
				$img_url = wp_get_attachment_image_url( $img_id, [ 60, 60 ] );
				$str = '<img src="' . $img_url . '" />';
			} else {
				$str = '<span aria-hidden="true">—</span><span class="screen-reader-text">' . __( 'No image' ) . '</span>';
			}
		}

		return $str;
	}
}


/**
 * Initializing Class Term_img.
 *
 * Инициализация класса Term_img.
 *
 * @return void
 *
 * @since 0.0.1
 * @author Ravil
 */
function term_img_init() {
	$taxs = [
		'category',
		'product_cat'
	];

	$taxs = apply_filters( 'BRI_Term_img_atts', $taxs );

	/*Helper::debug( $taxs );
	exit;*/

	if ( ! empty( $taxs ) )
		new Term_img( $taxs );
}

add_action( 'admin_init', __NAMESPACE__ . '\\term_img_init');
