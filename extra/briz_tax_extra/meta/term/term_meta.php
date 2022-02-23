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
		if (
			! is_array( $this->opts ) ||
			! array_key_exists( $tax_slug, $this->opts ) ||
			! array_key_exists( '__to_all__', $this->opts[ $tax_slug ] ) ||
			! $fields = $this->opts[ $tax_slug ][ '__to_all__' ]
		) return;

		$meta[ 'taxonomy' ] = $tax_slug;
		$meta[ 'tmpl' ] = '__to_all__';
		$meta[ 'fields' ] = $fields[ 'fields' ];
		$meta[ 'page' ] = 'term';
		$meta[ 'action' ] = 'add';
		$meta[ 'id' ] = '';
		$meta[ 'wp_object' ] = '';

		$this->fields_iterator( $meta );
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

		$id = $term->term_id;
		$tmpl_path = get_term_meta( $id, 'tmpl', $tax_slug );
		$meta[ 'taxonomy' ] = $tax_slug;
		$meta[ 'page' ] = 'term';
		$meta[ 'action' ] = 'edit';
		$meta[ 'id' ] = $id;
		$meta[ 'wp_object' ] = $term;

		if ( '' !== $tmpl_path && -1 != $tmpl_path ) {
			$tmpl_info = pathinfo( $tmpl_path );
			$tmpl_name = $tmpl_info[ 'filename' ];

			if (
				array_key_exists( $tmpl_name, $this->opts[ $tax_slug ] ) &&
				$fields = $this->opts[ $tax_slug ][ $tmpl_name ]
			) {
				$meta[ 'fields' ] = $fields[ 'fields' ];
				$meta[ 'tmpl' ] = $tmpl_name;
				$this->fields_iterator( $meta );
			}
		}

		if (
			array_key_exists( '__to_all__', $this->opts[ $tax_slug ] ) &&
			$fields = $this->opts[ $tax_slug ][ '__to_all__' ]
		) {
			$meta[ 'fields' ] = $fields[ 'fields' ];
			$meta[ 'tmpl' ] = '__to_all__';
			$this->fields_iterator( $meta );
		}
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

		if ( ! isset( $_POST[ $this->id_prefix ] ) )
			return;

		$term_fields = $_POST[ $this->id_prefix ];
		if ( empty( $term_fields ) )
			return;

		if ( ! current_user_can( 'edit_term', $term_id ) )
			return;

		$screen = null;
		if ( isset( $_POST['_wpnonce'] ) )
			$screen = 'edit';
		elseif ( isset( $_POST[ '_wpnonce_add-tag' ] ) )
			$screen = 'add';

		if ( ! $screen ) {
			return;
		} else {
			if ( 'edit' == $screen ) {
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], "update-tag_$term_id" ) )
					return;
			} else {
				if ( ! wp_verify_nonce( $_POST['_wpnonce_add-tag'], 'add-tag' ) )
					return;
			}
		}

		foreach ( $_POST[ $this->id_prefix ] as $key => $val ) {
			if ( ! $val && $val !== '0' ) {
				delete_term_meta( $term_id, $key ); // Полей нет.
			} else {
				update_term_meta( $term_id, $key, $val );
			}
		}
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
