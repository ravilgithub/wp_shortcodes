<?php
namespace Bri_Shortcodes;

// trait Meta_Extra {
class Term_Meta_Opts {
	// public $meta_key = 'briz-term-img-id';

	public $meta_key  = '';
	public $id_prefix = 'briz';
	public $taxs      = [];
	public $opts      = [];
	public $prepared_opts = [];


	// public function __construct( $screens, $taxs ) {
	public function __construct( Array $taxs ) {
		// Helper::debug( __CLASS__, '200px' );
		$this->taxs = $taxs;
		// $this->screens = $screens;

		// Helper::debug( PLUGIN_PATH . 'extra/bri_tax_extra/meta/meta_opts.php', '200px' );

		require_once( PLUGIN_PATH . 'extra/bri_tax_extra/meta/term/opts.php' );
		$this->opts = apply_filters( "{$this->id_prefix}_term_meta_opts", $opts );
		// Helper::debug( $this->opts );

		// $this->add_assets();
		// $this->field_iterator();
		$this->add_hooks( $taxs );
	}


	public function add_assets() {
		$assets = [
			'css' => [
				/************ TMPL CSS ************/
				'id'   => 'metabox-tmpl-css',
				'src'  => PLUGIN_URL . 'extra/bri_tax_extra/assets/css/metabox.min.css',
				'deps' => [],
				'ver'  => '1.0.0'
			],
			'js' => [
				/************ TMPL SCRIPTS ************/
				'id'   => 'metabox-tmpl-js',
				'src'  => PLUGIN_URL . 'extra/bri_tax_extra/assets/js/metabox.js',
				'deps' => [ 'jquery' ],
				'ver'  => '1.0.0',
				'in_footer' => true
			]
		];

		$assets = apply_filters( "{$this->id_prefix}_metabox_assets", $assets );

		// Helper::debug( $assets );

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

	// Нет возможность передать параметры в callback функцию.
	/*public function field_iterator() {
		if ( empty( $this->opts ) )
			return;

		foreach ( $this->opts as $tax_name => $fields ) {
			if ( ! in_array( $tax_name, $this->taxs ) )
				continue;

			foreach ( $fields as $field_name => $field_opts ) {
				if ( ! empty( $field_opts ) ) {
					$meta_key = $this->id_prefix . '[' . $tax_name . '][' . $field_name . ']';
					
					// $this->prepared_opts[] = [
					// 	$meta_key => $field_opts
					// ];

					$this->prepared_opts[ $meta_key ] = $field_opts;
				}
			}
		}

		// Helper::debug( $this->opts );
		Helper::debug( $this->taxs, '200px' );
		Helper::debug( $this->prepared_opts[ 'briz[category][option_1]' ], '200px' );
	}*/


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


	public function get_value( $term, $field_key ) {
		$field_value = get_term_meta( $term->term_id, $field_key, true );
		return $field_value ?: $field_params[ 'value' ];
	}


	public function field_iterator( $tax_slug, $edit = false, $term = null ) {
		$fields = $this->opts[ $tax_slug ];
		foreach ( $fields as $field_name => $field_params ) {
			if ( ! array_key_exists( 'type', $field_params ) )
				continue;

			$field_type = $edit ? $field_params[ 'type' ] . '_edit' : $field_params[ 'type' ];

			Helper::debug( $field_type );

			if ( method_exists( $this, $field_type ) ) {
				$field_key = $this->id_prefix . '[' . $tax_slug . ']' . '[' . $field_name . ']';

				if ( $edit && $term ) {
					$field_value = $this->get_value( $term, $field_key );
				}

				$field_value = $field_params[ 'value' ];
				$this->$field_type( $field_params, $field_key, $field_value );
			}
		}
	}


	// Нет возможность подписаться на хуки "manage_edit-{$tax_name}_columns" и "manage_{$tax_name}_custom_column"
	public function add_term_fields ( $tax_slug ) {
		if ( ! is_array( $this->opts ) || ! array_key_exists( $tax_slug, $this->opts ) )
			return;

		$this->field_iterator( $tax_slug );
	}


	public function edit_term_fields ( $term ) {
		Helper::debug( $term );

		$tax_slug = $term->taxonomy;
		if ( ! is_array( $this->opts ) || ! array_key_exists( $tax_slug, $this->opts ) )
			return;

		$this->field_iterator( $tax_slug, 'edit', $term );
	}


	public function save_term_fields( $term_id ) {
		Helper::debug( $term_id );
		Helper::debug( $_POST );
		exit;

		/*if ( ! isset( $_POST[ $this->meta_key ] ) ) return;
		if ( ! current_user_can( 'edit_term', $term_id ) ) return;
		if (
			! wp_verify_nonce( $_POST['_wpnonce'], "update-tag_$term_id" ) &&
			! wp_verify_nonce( $_POST['_wpnonce_add-tag'], 'add-tag' )
		) return;

		$val = ( int ) sanitize_text_field( wp_unslash( $_POST[ $this->meta_key ] ) );

		if ( ! $val )
			delete_term_meta( $term_id, $this->meta_key );
		else
			update_term_meta( $term_id, $this->meta_key, $val );*/
	}


	public function text( $field_params, $field_key, $field_value ) {
		Helper::debug( 'Text ------------------------------------' );
		Helper::debug( $field_params );
?>
		<div class="form-field">
			<label
				for="<?php echo esc_attr( $field_key ); ?>"
			><?php _e( $field_params[ 'title' ] ); ?></label>

			<input
				id="<?php echo esc_attr( $field_key ); ?>"
				name="<?php echo esc_attr( $field_key ); ?>"
				type="text"
				value="<?php echo esc_attr( $field_value ); ?>"
				size="40"
				aria-required="false"
			/>

			<p><?php _e( $field_params[ 'desc' ] ); ?></p>
		</div>
<?php
	}


	public function text_edit( $field_params, $field_key, $field_value ) {
		Helper::debug( 'Text ------------------------------------' );
		Helper::debug( $field_params );
?>
		<tr class="form-field term-briz-text-wrap">
			<th scope="row">
				<label
					for="<?php echo esc_attr( $field_key ); ?>"
				><?php _e( $field_params[ 'title' ] ); ?></label>
			</th>
			<td>
				<input
					id="<?php echo esc_attr( $field_key ); ?>"
					name="<?php echo esc_attr( $field_key ); ?>"
					type="text"
					value="<?php echo esc_attr( $field_value ); ?>"
					size="40"
					aria-required="false"
				/>

				<p><?php _e( $field_params[ 'desc'] ); ?></p>
			</td>
		</tr>
<?php
	}


	public function image ( $tax_slug ) {
		// Helper::debug( $tax_slug );
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

	/*Helper::debug( $taxs );
	exit;*/

	if ( ! empty( $taxs ) )
		new Term_Meta_Opts( $taxs );
}

add_action( 'admin_init', __NAMESPACE__ . '\\term_meta_opt_init' );
