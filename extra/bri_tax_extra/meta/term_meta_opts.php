<?php
namespace Bri_Shortcodes;

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
class Term_Meta_Opts extends Meta {
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

		require_once( PLUGIN_PATH . 'extra/bri_tax_extra/meta/term/opts.php' );
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
		$method_suffix = '';
		if ( is_object( $term ) ) {
			$stored = get_term_meta( $term->term_id, $this->id_prefix, true );
			$method_suffix = '_edit';
		}

		foreach ( $this->opts[ $tax_slug ] as $field_name => $field_params ) {
			if (
				! array_key_exists( 'value', $field_params ) ||
				! array_key_exists( 'type', $field_params )
			) continue;

			$field_value = $field_params[ 'value' ];
			$field_type = $field_params[ 'type' ] . $method_suffix;

			if (
				( ! empty( $stored ) && array_key_exists( $field_name, $stored ) ) &&
				( $stored[ $field_name ] || '0' === $stored[ $field_name ] )
			) $field_value = $stored[ $field_name ];

			if ( method_exists( $this, $field_type ) ) {
				$field_key = $this->id_prefix . '[' . $tax_slug . ']' . '[' . $field_name . ']';
				$this->$field_type( $field_key, $field_value, $field_params );
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


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $field_params - параметры мета поля.
	 * @param String $field_key   - имя мета поля.
	 * @param String $field_value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function text( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/text.php';
		require apply_filters( 'briz_meta_text_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $field_params - параметры мета поля.
	 * @param String $field_key   - имя мета поля.
	 * @param String $field_value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function text_edit( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/text_edit.php';
		require apply_filters( 'briz_meta_text_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $field_params - параметры мета поля.
	 * @param String $field_key   - имя мета поля.
	 * @param String $field_value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function textarea( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/textarea.php';
		require apply_filters( 'briz_meta_textarea_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $field_params - параметры мета поля.
	 * @param String $field_key   - имя мета поля.
	 * @param String $field_value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function textarea_edit( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/textarea_edit.php';
		require apply_filters( 'briz_meta_textarea_edit_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $field_params - параметры мета поля.
	 * @param String $field_key   - имя мета поля.
	 * @param String $field_value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function color( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/color.php';
		require apply_filters( 'briz_meta_color_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $field_params - параметры мета поля.
	 * @param String $field_key   - имя мета поля.
	 * @param String $field_value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function color_edit( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/color_edit.php';
		require apply_filters( 'briz_meta_color_edit_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $field_params - параметры мета поля.
	 * @param String $field_key   - имя мета поля.
	 * @param String $field_value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function number( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/number.php';
		require apply_filters( 'briz_meta_number_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $field_params - параметры мета поля.
	 * @param String $field_key   - имя мета поля.
	 * @param String $field_value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function number_edit( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/number_edit.php';
		require apply_filters( 'briz_meta_number_edit_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $field_params - параметры мета поля.
	 * @param String $field_key   - имя мета поля.
	 * @param String $field_value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function select( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/select.php';
		require apply_filters( 'briz_meta_select_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $field_params - параметры мета поля.
	 * @param String $field_key   - имя мета поля.
	 * @param String $field_value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function select_edit( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/select_edit.php';
		require apply_filters( 'briz_meta_select_edit_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $params - параметры мета поля.
	 * @param String $key   - имя мета поля.
	 * @param String $value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function checkbox( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/checkbox.php';
		require apply_filters( 'briz_meta_checkbox_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $params - параметры мета поля.
	 * @param String $key   - имя мета поля.
	 * @param String $value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function checkbox_edit( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/checkbox_edit.php';
		require apply_filters( 'briz_meta_checkbox_edit_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $params - параметры мета поля.
	 * @param String $key   - имя мета поля.
	 * @param String $value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function range( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/range.php';
		require apply_filters( 'briz_meta_range_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $params - параметры мета поля.
	 * @param String $key   - имя мета поля.
	 * @param String $value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function range_edit( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/range_edit.php';
		require apply_filters( 'briz_meta_range_edit_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $params - параметры мета поля.
	 * @param String $key   - имя мета поля.
	 * @param String $value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function radio( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/radio.php';
		require apply_filters( 'briz_meta_radio_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $params - параметры мета поля.
	 * @param String $key   - имя мета поля.
	 * @param String $value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function radio_edit( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/radio_edit.php';
		require apply_filters( 'briz_meta_radio_edit_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $params - параметры мета поля.
	 * @param String $key   - имя мета поля.
	 * @param String $value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function url( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/url.php';
		require apply_filters( 'briz_meta_url_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $params - параметры мета поля.
	 * @param String $key   - имя мета поля.
	 * @param String $value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function url_edit( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/url_edit.php';
		require apply_filters( 'briz_meta_url_edit_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $params - параметры мета поля.
	 * @param String $key   - имя мета поля.
	 * @param String $value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function wp_editor( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/wp_editor.php';
		require apply_filters( 'briz_meta_wp_editor_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $params - параметры мета поля.
	 * @param String $key   - имя мета поля.
	 * @param String $value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function wp_editor_edit( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/wp_editor_edit.php';
		require apply_filters( 'briz_meta_wp_editor_edit_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $params - параметры мета поля.
	 * @param String $key   - имя мета поля.
	 * @param String $value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function image( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/image.php';
		require apply_filters( 'briz_meta_image_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param Array $params - параметры мета поля.
	 * @param String $key   - имя мета поля.
	 * @param String $value - значение мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function image_edit ( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/image_edit.php';
		require apply_filters( 'briz_meta_image_edit_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param String $key - имя мета поля.
	 * @param String $value - значение мета поля.
	 * @param Array $params - параметры мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function media_button( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/media_button.php';
		require apply_filters( 'briz_meta_media_button_component', $component_path, $key, $value, $params );
	}


	/**
	 * HTML meta field.
	 *
	 * HTML разметка мета поля.
	 *
	 * @param String $key - имя мета поля.
	 * @param String $value - значение мета поля.
	 * @param Array $params - параметры мета поля.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function media_button_edit( $key, $value, $params ) {
		$component_path = PLUGIN_PATH . 'extra/bri_tax_extra/meta/inc/media_button_edit.php';
		require apply_filters( 'briz_meta_media_button_edit_component', $component_path, $key, $value, $params );
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
function term_meta_opt_init() {
	$taxs = [
		'category',
		'product_cat'
	];

	$taxs = apply_filters( 'BRI_Term_meta_opt_atts', $taxs );

	if ( ! empty( $taxs ) )
		new Term_Meta_Opts( $taxs );
}

add_action( 'admin_init', __NAMESPACE__ . '\\term_meta_opt_init' );
