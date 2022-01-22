<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\meta\term;
use Briz_Shortcodes\extra\briz_tax_extra\meta\Meta;
use Briz_Shortcodes\common\Helper;

/**
 * The class implements the ability to add meta fields to a term.
 *
 * Класс реализует возможность добавлять мета поля термину.
 *
 * @property String $id_refix - префикс идентификатора метабокса и его полей.
 *                              Default: "briz_term_meta".
 * @property Array $taxs      - таксономии к записям которых добавляются метабоксы.
 * @property Array $opts      - параметры полей по умолчанию.
 *
 * @since 0.0.1
 * @author Ravil
 */
class Term_Meta extends Meta {
	public $id_prefix = 'briz_term_meta';
	public $taxs      = [];
	public $opts      = [];


	/**
	* Constructor.
	*
	* @param Array $taxs - таксономии к терминам которых добавляются
	*                      мета поля.
	*
	* @return void.
	*
	* @since 0.0.1
	* @author Ravil
	*/
	public function __construct( Array $taxs ) {
		$this->taxs = $taxs;

		parent::__construct();

		require_once( PLUGIN_PATH . 'extra/briz_tax_extra/meta/term/opts.php' );
		$this->opts = apply_filters( "{$this->id_prefix}_term_meta_opts", $opts );

		$this->add_hooks( $taxs );
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
				'add_term_fields'
			] );

			add_action( "{$tax_name}_edit_form_fields", [
				$this,
				'edit_term_fields'
			] );

			add_action( "created_{$tax_name}", [
				$this,
				'save_term_fields'
			] );

			add_action( "edited_{$tax_name}", [
				$this,
				'save_term_fields'
			] );

			/*add_filter( "manage_edit-{$tax_name}_columns", [
				$this,
				'add_field_column'
			] );*/

			/*add_filter( "manage_{$tax_name}_custom_column", [
				$this,
				'fill_field_column'
			], 10, 3 );*/
		}
	}


	/**
	 * Iteration of the theme's meta fields obtained
	 * from the file "term / opts.php".
	 *
	 * Перебор мета полей темина полученных из файла "term/opts.php".
	 *
	 * @param String $tax_slug     - Ярлык термина.
	 * @param WP_Term Object $term - Объект термина.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function field_iterator( $tax_slug, $term = null ) {
		$term_slug = null;
		$term_meta = null;
		$component_suffix = '';

		// $term передаётся только для страницы "term edit".
		if ( is_object( $term ) ) {
			$term_slug = $term->slug;
			$term_meta = get_term_meta( $term->term_id, $this->id_prefix, true );
			$component_suffix = '_edit';
		}

		foreach ( $this->opts[ $tax_slug ] as $term_name => $data ) {
			if ( ! is_array( $data ) || ! array_key_exists( 'fields', $data ) ) {
				continue;
			}

			if ( $term_name === $term_slug || $term_name === '__to_all__' ) {
				foreach ( $data[ 'fields' ] as $field_name => $params ) {
					if (
						! array_key_exists( 'value', $params ) ||
						! array_key_exists( 'type', $params )
					) continue;

					$key = $this->id_prefix . '[' . $tax_slug . ']' . '[' . $field_name . ']';
					$value = '';
					$saved = false;

					if (
						is_array( $term_meta ) &&
						array_key_exists( $field_name, $term_meta )
					) {
						if (
							! $term_meta[ $field_name ] &&
							'0' !== $term_meta[ $field_name ] &&
							(
								! array_key_exists( 'empty', $params ) ||
								! $params[ 'empty' ]
							)
						) {
							// Значение не можен быть пустым. берём его значение по умолчанию. Файл "opts.php".
							$value = $params[ 'value' ];
						} else {
							// Получаем значение поля из БД.
							$value = $term_meta[ $field_name ];
							$saved = true;
						}
					} else {
						// Добавленно новое поле, берём его значение по умолчанию. Файл "opts.php".
						$value = $params[ 'value' ];
					}

					// Сортировка медиа файлов.
					if ( 'media_button' === $params[ 'type' ] && $value && '[]' !== $value ) {
						$value = $this->sort_attachment_files( $value, $params );
					}

					$this->require_component( $key, $value, $params, $component_suffix, $saved );
				}
			}
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
	public function add_term_fields ( $tax_slug ) {
		if ( ! is_array( $this->opts ) || ! array_key_exists( $tax_slug, $this->opts ) )
			return;

		$this->field_iterator( $tax_slug );
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
	public function edit_term_fields ( $term ) {
		$tax_slug = $term->taxonomy;
		if ( ! is_array( $this->opts ) || ! array_key_exists( $tax_slug, $this->opts ) )
			return;

		$this->field_iterator( $tax_slug, $term );
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
	public function save_term_fields( $term_id ) {
		$term = get_term( $term_id );
		$tax_name = $term->taxonomy;

		if ( ! isset( $_POST[ $this->id_prefix ][ $tax_name ] ) ) return;

		$term_fields = $_POST[ $this->id_prefix ][ $tax_name ];
		if ( empty( $term_fields ) ) return;

		if ( ! current_user_can( 'edit_term', $term_id ) ) return;
		if (
			! wp_verify_nonce( $_POST['_wpnonce'], "update-tag_$term_id" ) &&
			! wp_verify_nonce( $_POST['_wpnonce_add-tag'], 'add-tag' )
		) return;

		foreach ( $term_fields as $field_name => $field_value ) {
			if ( ! is_array( $field_value ) ) {
				// Для "wp_editor" и остальных типов полей.
				$field_value = wp_kses( wp_unslash( $field_value ), 'post' );
			} else {
				// Для полей типа "checkbox".
				foreach ( $field_value as $k => $v ) {
					$field_value[ $k ] = sanitize_text_field( wp_unslash( $v ) );
				}
			}

			$term_fields[ $field_name ] = $field_value;
		}

		if ( ! $term_fields )
			delete_term_meta( $term_id, $this->id_prefix ); // Полей нет.
		else
			update_term_meta( $term_id, $this->id_prefix, $term_fields );
	}
}

/**
 * Initializing Class Term_Meta.
 *
 * Инициализация класса Term_Meta.
 *
 * @return void
 *
 * @since 0.0.1
 * @author Ravil
 */
function term_meta_init() {
	$taxs = [
		'category',
		'product_cat'
	];

	$taxs = apply_filters( 'BRIZ_Term_Meta_Atts', $taxs );

	if ( ! empty( $taxs ) )
		new Term_Meta( $taxs );
}

add_action( 'admin_init', __NAMESPACE__ . '\\term_meta_init' );
