<?php
namespace Bri_Shortcodes;

// trait Meta_Extra {
class Term_Meta_Opts {
	// public $meta_key = 'briz-term-img-id';

	public $meta_key  = '';
	public $id_prefix = 'briz_term_meta';
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


	/**
	 * We get the meta fields of the term from the database,
	 * if there are none, then we return the parameters related
	 * to this field from the file "term / opts.php".
	 *
	 * Получаем мета поля термина из БД, если таковых нет то возвращаем
	 * параметры относящиеся к этому полю из файла "term/opts.php".
	 *
	 * @param WP_Term Object $term  - Объект термина.
	 * @param String $field_key     - Ключ поля термина.
	 * @param Array $default_params - Параметры полей по умолчанию.
	 *
	 * @return Array $field_value   - мета поля термина.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function get_value( $term, $field_key, $default_params ) {
		if ( ! $term )
			return $default_params;

		$field_value = get_term_meta( $term->term_id, $field_key, true );
		return ! empty( $field_value ) ? $field_value : $default_params;
	}


	/**
	 * Enumeration of term meta fields obtained from
	 * the database or from the "term/opts.php" file.
	 *
	 * Перебор мета полей темина полученных из базы
	 * данных или из файла "term/opts.php".
	 *
	 * @param String $tax_slug     - Ярлык термина.
	 * @param String $edit         - Флаг указывающий на то, что метод
	 *                               вызван для формы на странице редактирования
	 *                               мета полей термина.
	 * @param WP_Term Object $term - Объект термина.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function field_iterator_back( $tax_slug, $edit = false, $term = null ) {
		$fields = $this->get_value( $term, $this->id_prefix, $this->opts[ $tax_slug ] );

		foreach ( $fields as $field_name => $field_value ) {

			/**
			 * Если значения мета полей получены из БД ( String $field_value ),
			 * то для формирования полей формы нужны параметры,
			 * относящиеся к этому полю из файла "term/opts.php".
			 */
			if ( ! is_array( $field_value ) || ! array_key_exists( 'type', $field_value ) ) {
				if ( ! array_key_exists( 'type', $this->opts[ $tax_slug ][ $field_name ] ) )
					continue;
				$default_params = $this->opts[ $tax_slug ][ $field_name ];
			} else {
				$default_params = $field_value;
				$field_value = $default_params[ 'value' ];
			}

			$field_type = $edit ? $default_params[ 'type' ] . '_edit' : $default_params[ 'type' ];

			if ( method_exists( $this, $field_type ) ) {
				$field_key = $this->id_prefix . '[' . $tax_slug . ']' . '[' . $field_name . ']';
				$this->$field_type( $default_params, $field_key, $field_value );
			}
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
		// Helper::debug( $term );

		$tax_slug = $term->taxonomy;
		if ( ! is_array( $this->opts ) || ! array_key_exists( $tax_slug, $this->opts ) )
			return;

		// $this->field_iterator( $tax_slug, 'edit', $term );
		$this->field_iterator( $tax_slug, $term );
	}


	public function save_term_fields( $term_id ) {
		$term = get_term( $term_id );
		$tax_name = $term->taxonomy;
		// Helper::debug( $term_id );
		// Helper::debug( $tax );
		// Helper::debug( $_POST );
		// Helper::debug( $_POST[ $this->id_prefix ][ $tax_name ] );
		// exit;

		if ( ! isset( $_POST[ $this->id_prefix ][ $tax_name ] ) ) return;

		$term_fields = $_POST[ $this->id_prefix ][ $tax_name ];
		if ( empty( $term_fields ) ) return;

		if ( ! current_user_can( 'edit_term', $term_id ) ) return;
		if (
			! wp_verify_nonce( $_POST['_wpnonce'], "update-tag_$term_id" ) &&
			! wp_verify_nonce( $_POST['_wpnonce_add-tag'], 'add-tag' )
		) return;

		foreach ( $term_fields as $field_name => $field_value ) {
			$field_value = sanitize_text_field( wp_unslash( $field_value ) );
			$term_fields[ $field_name ] = $field_value;
		}

		if ( ! $term_fields )
			delete_term_meta( $term_id, $this->id_prefix ); // Полей нет.
		else
			update_term_meta( $term_id, $this->id_prefix, $term_fields );
	}


	public function text( $field_params, $field_key, $field_value ) {
		/*Helper::debug( 'Text ------------------------------------' );
		Helper::debug( $field_params );*/
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
		/*Helper::debug( 'Text ------------------------------------' );
		Helper::debug( $field_params );*/
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


	public function textarea( $field_params, $field_key, $field_value ) {
		/*Helper::debug( 'Textarea ------------------------------------' );
		Helper::debug( $field_params );*/
?>
		<div class="form-field">
			<label
				for="<?php echo esc_attr( $field_key ); ?>"
			><?php _e( $field_params[ 'title' ] ); ?></label>

			<textarea
				name="<?php echo esc_attr( $field_key ); ?>"
				id="<?php echo esc_attr( $field_key ); ?>"
				rows="5"
				cols="50"
				class="large-text"
			><?php _e( $field_value ); ?></textarea>

			<p><?php _e( $field_params[ 'desc' ] ); ?></p>
		</div>
<?php
	}


	public function textarea_edit( $field_params, $field_key, $field_value ) {
		/*Helper::debug( 'Textarea edit ------------------------------------' );
		Helper::debug( $field_params );*/
?>
		<tr class="form-field term-briz-textarea-wrap">
			<th scope="row">
				<label
					for="<?php echo esc_attr( $field_key ); ?>"
				><?php _e( $field_params[ 'title' ] ); ?></label>
			</th>
			<td>
				<textarea
					name="<?php echo esc_attr( $field_key ); ?>"
					id="<?php echo esc_attr( $field_key ); ?>"
					rows="5"
					cols="50"
					class="large-text"
				><?php _e( $field_value ); ?></textarea>

				<p><?php _e( $field_params[ 'desc'] ); ?></p>
			</td>
		</tr>
<?php
	}


	public function color( $field_params, $field_key, $field_value ) {
		/*Helper::debug( 'Text ------------------------------------' );
		Helper::debug( $field_params );*/
?>
		<div class="form-field">
			<label
				for="<?php echo esc_attr( $field_key ); ?>"
			><?php _e( $field_params[ 'title' ] ); ?></label>

			<input
				id="<?php echo esc_attr( $field_key ); ?>"
				name="<?php echo esc_attr( $field_key ); ?>"
				type="color"
				value="<?php echo esc_attr( $field_value ); ?>"
				aria-required="false"
			/>

			<p><?php _e( $field_params[ 'desc' ] ); ?></p>
		</div>
<?php
	}


	public function color_edit( $field_params, $field_key, $field_value ) {
		/*Helper::debug( 'Text ------------------------------------' );
		Helper::debug( $field_params );*/
?>
		<tr class="form-field term-briz-color-wrap">
			<th scope="row">
				<label
					for="<?php echo esc_attr( $field_key ); ?>"
				><?php _e( $field_params[ 'title' ] ); ?></label>
			</th>
			<td>
				<input
					id="<?php echo esc_attr( $field_key ); ?>"
					name="<?php echo esc_attr( $field_key ); ?>"
					type="color"
					value="<?php echo esc_attr( $field_value ); ?>"
					aria-required="false"
				/>

				<p><?php _e( $field_params[ 'desc'] ); ?></p>
			</td>
		</tr>
<?php
	}


	public function number( $field_params, $field_key, $field_value ) {
		// Helper::debug( 'Number ------------------------------------' );
		// Helper::debug( $field_params );
?>
		<div class="form-field">
			<label
				for="<?php echo esc_attr( $field_key ); ?>"
			><?php _e( $field_params[ 'title' ] ); ?></label>

			<input
				id="<?php echo esc_attr( $field_key ); ?>"
				name="<?php echo esc_attr( $field_key ); ?>"
				type="number"
				value="<?php echo esc_attr( $field_value ); ?>"
				step="<?php echo esc_attr( $field_params[ 'options' ][ 'step' ] ); ?>"
				min="<?php echo esc_attr( $field_params[ 'options' ][ 'min' ] ); ?>"
				max="<?php echo esc_attr( $field_params[ 'options' ][ 'max' ] ); ?>"
				aria-required="false"
			/>

			<p><?php _e( $field_params[ 'desc' ] ); ?></p>
		</div>
<?php
	}


	public function number_edit( $field_params, $field_key, $field_value ) {
		// Helper::debug( 'Number ------------------------------------' );
		// Helper::debug( $field_params );
?>
		<tr class="form-field term-briz-number-wrap">
			<th scope="row">
				<label
					for="<?php echo esc_attr( $field_key ); ?>"
				><?php _e( $field_params[ 'title' ] ); ?></label>
			</th>
			<td>
				<input
					id="<?php echo esc_attr( $field_key ); ?>"
					name="<?php echo esc_attr( $field_key ); ?>"
					type="number"
					value="<?php echo esc_attr( $field_value ); ?>"
					step="<?php echo esc_attr( $field_params[ 'options' ][ 'step' ] ); ?>"
					min="<?php echo esc_attr( $field_params[ 'options' ][ 'min' ] ); ?>"
					max="<?php echo esc_attr( $field_params[ 'options' ][ 'max' ] ); ?>"
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
