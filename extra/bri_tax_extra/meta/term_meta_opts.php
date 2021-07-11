<?php
namespace Bri_Shortcodes;

class Term_Meta_Opts {
	public $meta_key  = '';
	public $id_prefix = 'briz_term_meta';
	public $taxs      = [];
	public $opts      = [];
	public $prepared_opts = [];


	public function __construct( Array $taxs ) {
		$this->taxs = $taxs;

		require_once( PLUGIN_PATH . 'extra/bri_tax_extra/meta/term/opts.php' );
		$this->opts = apply_filters( "{$this->id_prefix}_term_meta_opts", $opts );

		$this->add_assets();
		$this->add_hooks( $taxs );
	}


	public function add_assets() {
		$assets = [
			'css' => [
				/************ TMPL CSS ************/
				'id'   => 'term-meta-css',
				'src'  => PLUGIN_URL . 'extra/bri_tax_extra/assets/css/term_meta.min.css',
				'deps' => [],
				'ver'  => '1.0.0'
			],
			'js' => [
				/************ TMPL SCRIPTS ************/
				'id'   => 'term-meta-js',
				'src'  => PLUGIN_URL . 'extra/bri_tax_extra/assets/js/term_meta.js',
				'deps' => [ 'jquery' ],
				'ver'  => '1.0.0',
				'in_footer' => true
			]
		];

		$assets = apply_filters( "{$this->id_prefix}_metabox_assets", $assets );

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
				$this->$field_type( $field_params, $field_key, $field_value );
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
	public function select( $field_params, $field_key, $field_value ) {
		// Helper::debug( 'Select ------------------------------------' );
		// Helper::debug( $field_params );
?>
		<div class="form-field term-briz-select-wrap">
			<label
				for="<?php echo esc_attr( $field_key ); ?>"
			><?php _e( $field_params[ 'title' ] ); ?></label>

			<select
				id="<?php echo esc_attr( $field_key ); ?>"
				name="<?php echo esc_attr( $field_key ); ?>"
			>
				<?php foreach ( $field_params[ 'options' ] as $k => $v ) : ?>
					<option
						value="<?php echo $k; ?>"
						<?php selected( $field_value, $k, true ); ?>
					><?php echo $v; ?></option>
				<?php endforeach; ?>
			</select>

			<p><?php _e( $field_params[ 'desc'] ); ?></p>
		</div>
<?php
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
	public function select_edit( $field_params, $field_key, $field_value ) {
		// Helper::debug( 'Select ------------------------------------' );
		// Helper::debug( $field_params );
?>
		<tr class="form-field term-briz-select-wrap">
			<th scope="row" valign="top">
				<label
					for="<?php echo esc_attr( $field_key ); ?>"
				><?php _e( $field_params[ 'title' ] ); ?></label>
			</th>
			<td>

				<select
					id="<?php echo esc_attr( $field_key ); ?>"
					name="<?php echo esc_attr( $field_key ); ?>"
				>
					<?php foreach ( $field_params[ 'options' ] as $k => $v ) : ?>
						<option
							value="<?php echo $k; ?>"
							<?php selected( $field_value, $k, true ); ?>
						><?php echo $v; ?></option>
					<?php endforeach; ?>
				</select>

				<p><?php _e( $field_params[ 'desc'] ); ?></p>
			</td>
		</tr>
<?php
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
	public function checkbox( $field_params, $field_key, $field_value ) {
		// Helper::debug( 'Checkbox ------------------------------------' );
?>
		<div class="form-field term-briz-checkbox-wrap">
			<span>
				<?php _e( $field_params[ 'title' ] ); ?>
			</span>

			<!--
				Если checkbox'ы не выбраны то в $_POST будет пустое поле,
				что позволит удалить его из БД.
			-->
			<input type="hidden" name="<?php echo $field_key; ?>" value="">

			<?php foreach ( $field_params[ 'options' ] as $k => $v ) : ?>
				<label>
					<input
						name="<?php echo $field_key . '[]'; ?>"
						type="checkbox"
						value="<?php echo $k; ?>"
						<?php checked( true, in_array( $k, (array) $field_value ) ); ?>
					/>
					<?php echo $v; ?>
				</label>
			<?php endforeach; ?>

			<p><?php _e( $field_params[ 'desc'] ); ?></p>
		</div>
<?php
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
	public function checkbox_edit( $field_params, $field_key, $field_value ) {
		// Helper::debug( 'Checkbox ------------------------------------' );
?>
		<tr class="form-field term-briz-checkbox-wrap">
			<th scope="row" valign="top">
				<span>
					<?php _e( $field_params[ 'title' ] ); ?>
				</span>
			</th>
			<td>

				<!--
					Если checkbox'ы не выбраны то в $_POST будет пустое поле,
					что позволит удалить его из БД.
				-->
				<input type="hidden" name="<?php echo $field_key; ?>" value="">

				<?php foreach ( $field_params[ 'options' ] as $k => $v ) : ?>
					<label>
						<input
							name="<?php echo $field_key . '[]'; ?>"
							type="checkbox"
							value="<?php echo $k; ?>"
							<?php checked( true, in_array( $k, (array) $field_value ) ); ?>
						/>
						<?php echo $v; ?>
					</label>
				<?php endforeach; ?>

				<p><?php _e( $field_params[ 'desc'] ); ?></p>
			</td>
		</tr>
<?php
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
	public function range( $field_params, $field_key, $field_value ) {
		// Helper::debug( 'range ------------------------------------' );
?>
		<div class="form-field term-briz-range-wrap">
			<span>
				<?php _e( $field_params[ 'title' ] ); ?>
			</span>

			<p>
				<?php _e( 'Current value' ); ?>:
				<span class="briz-range-current-value">
					<?php echo $field_value; ?>
				</span>
			</p>

			<input
				name="<?php echo $field_key; ?>"
				type="range"
				value="<?php echo $field_value; ?>"
				step="<?php echo $field_params[ 'options' ][ 'step' ]; ?>"
				min="<?php echo $field_params[ 'options' ][ 'min' ]; ?>"
				max="<?php echo $field_params[ 'options' ][ 'max' ]; ?>"
			/>

			<p><?php _e( $field_params[ 'desc'] ); ?></p>
		</div>
<?php
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
	public function range_edit( $field_params, $field_key, $field_value ) {
		// Helper::debug( 'range ------------------------------------' );
?>
		<tr class="form-field term-briz-range-wrap">
			<th scope="row" valign="top">
				<span>
					<?php _e( $field_params[ 'title' ] ); ?>
				</span>
			</th>
			<td>

				<p>
					<?php _e( 'Current value' ); ?>:
					<span class="briz-range-current-value">
						<?php echo $field_value; ?>
					</span>
				</p>

				<input
					name="<?php echo $field_key; ?>"
					type="range"
					value="<?php echo $field_value; ?>"
					step="<?php echo $field_params[ 'options' ][ 'step' ]; ?>"
					min="<?php echo $field_params[ 'options' ][ 'min' ]; ?>"
					max="<?php echo $field_params[ 'options' ][ 'max' ]; ?>"
				/>

				<p><?php _e( $field_params[ 'desc'] ); ?></p>
			</td>
		</tr>
<?php
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
	public function radio( $field_params, $field_key, $field_value ) {
		// Helper::debug( 'radio ------------------------------------' );
?>
		<div class="form-field term-briz-radio-wrap">
			<span>
				<?php _e( $field_params[ 'title' ] ); ?>
			</span>

			<?php foreach ( $field_params[ 'options' ] as $k => $v ) : ?>
				<label>
					<input
						type="radio"
						name="<?php echo $field_key; ?>"
						value="<?php echo $k; ?>"
						<?php checked( $k, $field_value ); ?>
					/>

					<?php echo $v; ?>
				</label>
			<?php endforeach; ?>

			<p><?php _e( $field_params[ 'desc'] ); ?></p>
		</div>
<?php
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
	public function radio_edit( $field_params, $field_key, $field_value ) {
		// Helper::debug( 'radio ------------------------------------' );
?>
		<tr class="form-field term-briz-radio-wrap">
			<th scope="row" valign="top">
				<span>
					<?php _e( $field_params[ 'title' ] ); ?>
				</span>
			</th>
			<td>

				<?php foreach ( $field_params[ 'options' ] as $k => $v ) : ?>
					<label>
						<input
							type="radio"
							name="<?php echo $field_key; ?>"
							value="<?php echo $k; ?>"
							<?php checked( $k, $field_value ); ?>
						/>

						<?php echo $v; ?>
					</label>
				<?php endforeach; ?>

				<p><?php _e( $field_params[ 'desc'] ); ?></p>
			</td>
		</tr>
<?php
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
	public function url( $field_params, $field_key, $field_value ) {
		// Helper::debug( 'url ------------------------------------' );
?>
		<div class="form-field term-briz-url-wrap">
			<span>
				<?php _e( $field_params[ 'title' ] ); ?>
			</span>

			<input
				type="url"
				name="<?php echo $field_key; ?>"
				value="<?php echo $field_value; ?>"
				pattern="<?php echo $field_params[ 'pattern' ]; ?>"
				required="<?php echo $field_params[ 'required' ] ? 'required' : ''; ?>"
			/>

			<p><?php _e( $field_params[ 'desc'] ); ?></p>
		</div>
<?php
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
	public function url_edit( $field_params, $field_key, $field_value ) {
		// Helper::debug( 'url ------------------------------------' );
?>
		<tr class="form-field term-briz-url-wrap">
			<th scope="row" valign="top">
				<span>
					<?php _e( $field_params[ 'title' ] ); ?>
				</span>
			</th>
			<td>

				<input
					type="url"
					name="<?php echo $field_key; ?>"
					value="<?php echo $field_value; ?>"
					pattern="<?php echo $field_params[ 'pattern' ]; ?>"
					required="<?php echo $field_params[ 'required' ] ? 'required' : ''; ?>"
				/>

				<p><?php _e( $field_params[ 'desc'] ); ?></p>
			</td>
		</tr>
<?php
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
	public function wp_editor( $field_params, $field_key, $field_value ) {
		// Helper::debug( 'wp editor ------------------------------------' );
		$args = array_merge(
			[
				'textarea_name'    => $field_key, //нужно указывать!
				'editor_class'     => 'editor-class',
				// изменяемое
				'wpautop'          => 1,
				'textarea_rows'    => 5,
				'tabindex'         => null,
				'editor_css'       => '',
				'teeny'            => 0,
				'dfw'              => 0,
				'tinymce'          => 1,
				'quicktags'        => 1,
				'media_buttons'    => false,
				'drag_drop_upload' => false
			],
			$field_params[ 'options' ]
		);
?>
		<div class="form-field term-briz-wp-editor-wrap">
			<span>
				<?php _e( $field_params[ 'title' ] ); ?>
			</span>

			<?php
				echo $field_value;

				wp_editor( $field_value, $field_key, $args );
			?>

			<p><?php _e( $field_params[ 'desc'] ); ?></p>
		</div>
<?php
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
	public function wp_editor_edit( $field_params, $field_key, $field_value ) {
		// Helper::debug( 'wp editor ------------------------------------' );
		$args = array_merge(
			[
				'textarea_name'    => $field_key, //нужно указывать!
				'editor_class'     => 'editor-class',
				// изменяемое
				'wpautop'          => 1,
				'textarea_rows'    => 5,
				'tabindex'         => null,
				'editor_css'       => '',
				'teeny'            => 0,
				'dfw'              => 0,
				'tinymce'          => 1,
				'quicktags'        => 1,
				'media_buttons'    => false,
				'drag_drop_upload' => false
			],
			$field_params[ 'options' ]
		);
?>
		<tr class="form-field term-briz-wp-editor-wrap">
			<th scope="row" valign="top">
				<span>
					<?php _e( $field_params[ 'title' ] ); ?>
				</span>
			</th>
			<td>

				<?php
					echo $field_value;

					wp_editor( $field_value, $field_key, $args );
				?>

				<p><?php _e( $field_params[ 'desc'] ); ?></p>
			</td>
		</tr>
<?php
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
	public function image( $field_params, $field_key, $field_value ) {
		// Helper::debug( $tax_slug );
?>
		<div class="form-field briz-term-img-wrap">
			<label><?php _e( 'Image' ); ?></label>

			<figure>
				<a href="#">
					<img
						src="<?php echo esc_attr( $field_value ); ?>"
						data-default="<?php echo esc_attr( $field_params[ 'value' ] ); ?>"
						alt="Alt"
					/>
				</a>

				<button type="button" class="button hidden">
					<?php _e( 'Remove' ); ?>
				</button>
			</figure>

			<p><?php _e( $field_params[ 'desc'] ); ?></p>

			<input
				type="hidden"
				name="<?php echo esc_attr( $field_key ); ?>"
				value=""
			/>
		</div>
<?php
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
	public function image_edit ( $field_params, $field_key, $field_value ) {
		$img_id = ( int ) $field_value;
		$img_url = $field_params[ 'value' ];
		$btn_class = 'hidden';

		if ( $img_id ) {
			$img_url = wp_get_attachment_image_url( $img_id, [ 60, 60 ] );
			$btn_class = '';
		}
?>
		<tr class="form-field briz-term-img-wrap">
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
							data-default="<?php echo esc_attr( $field_params[ 'value' ] ); ?>"
							alt="Alt"
						/>
					</a>

					<button type="button" class="button <?php echo esc_attr( $btn_class ); ?>">
						<?php _e( 'Remove' ); ?>
					</button>
				</figure>

				<p><?php _e( $field_params[ 'desc'] ); ?></p>

				<input
					type="hidden"
					name="<?php echo esc_attr( $field_key ); ?>"
					value="<?php echo esc_attr( $img_id ); ?>"
				/>
			</td>
		</tr>
<?php
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
	public function media_button( $field_params, $field_key, $field_value ) {
		$defaults = [
			'title'    => 'Insert a media',
			'library'  => [ 'type' => 'image' ],
			'multiple' => false,
			'button'   => [ 'text' => 'Insert' ]
		];

		$opts = wp_parse_args( $field_params[ 'options' ], $defaults );
		extract( $opts );

		$stage = 'addidable';
		$add_action_txt = __( 'Add медиафайлы' );
		$edit_action_txt = __( 'Edit медиафайлы' );
		$btn_action_txt = $add_action_txt;
		$delBtnClass = '';

		if ( $field_value ) {
			$stage = 'editable';
			$btn_action_txt = $edit_action_txt;
			$delBtnClass = 'briz-del-media-button-active';
		}
?>
		<div class="form-field briz-term-media-button-wrap">
			<label><?php echo $field_params[ 'title' ]; ?></label>

			<button
				type="button"
				class="button briz-term-media-button"
				data-title="<?php echo $title; ?>"
				data-library-type="<?php echo $library[ 'type' ]; ?>"
				data-multiple="<?php echo $multiple; ?>"
				data-button-text="<?php echo $button[ 'text' ]; ?>"
				data-action-text="<?php echo $edit_action_txt; ?>"
				data-stage="<?php echo $stage; ?>"
			>
				<?php echo $btn_action_txt; ?>
			</button>

			<button
				type="button"
				class="button briz-del-media-button <?php echo $delBtnClass; ?>"
				data-action-text="<?php echo $add_action_txt; ?>"
			>
				<?php echo __( 'Удалить медиафайлы' ); ?>
			</button>

			<p><?php _e( $field_params[ 'desc'] ); ?></p>

			<figure>
				<span class="briz-media-place">
<?php
						if ( $field_value ) :
							$value = json_decode( $field_value );
							if ( ! empty( $value ) ) :
								foreach ( $value as $media_id ) :
									$details = wp_prepare_attachment_for_js( $media_id );
									$src = $details[ 'url' ];

									if ( $caption = $details[ 'caption' ] ) :
?>
										<figcaption>
											<?php echo $caption; ?>
										</figcaption>
<?php
									endif;

									// Image
									if ( 'image' == $library[ 'type' ] ) :
?>
										<img
											src="<?php echo $src; ?>"
											alt="<?php echo $details[ 'alt' ]; ?>"
										/>
<?php
									// Audio
									elseif ( 'audio' == $library[ 'type' ] ) :
?>
										<audio src="<?php echo $src; ?>" controls></audio>
<?php
									// Video
									elseif ( 'video' == $library[ 'type' ] ) :
?>
										<video src="<?php echo $src; ?>" controls></video>
<?php
									endif;
								endforeach;
							endif;
						endif;
?>
				</span>
			</figure>

			<input
				type="hidden"
				name="<?php echo $field_key; ?>"
				value="<?php echo $field_value ?>"
			/>
		</div>
<?php
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
	public function media_button_edit( $field_params, $field_key, $field_value ) {
		$defaults = [
			'title'    => 'Insert a media',
			'library'  => [ 'type' => 'image' ],
			'multiple' => false,
			'button'   => [ 'text' => 'Insert' ]
		];

		$opts = wp_parse_args( $field_params[ 'options' ], $defaults );
		extract( $opts );

		$stage = 'addidable';
		$add_action_txt = __( 'Add медиафайлы' );
		$edit_action_txt = __( 'Edit медиафайлы' );
		$btn_action_txt = $add_action_txt;
		$delBtnClass = '';

		if ( $field_value ) {
			$stage = 'editable';
			$btn_action_txt = $edit_action_txt;
			$delBtnClass = 'briz-del-media-button-active';
		}
?>
		<tr class="form-field briz-term-media-button-wrap">
			<td>
				<span class="briz_meta_field_title">
					<?php echo $field_params[ 'title' ]; ?>
				</span>
			</td>

			<td>
				<button
					type="button"
					class="button briz-term-media-button"
					data-title="<?php echo $title; ?>"
					data-library-type="<?php echo $library[ 'type' ]; ?>"
					data-multiple="<?php echo $multiple; ?>"
					data-button-text="<?php echo $button[ 'text' ]; ?>"
					data-action-text="<?php echo $edit_action_txt; ?>"
					data-stage="<?php echo $stage; ?>"
				>
					<?php echo $btn_action_txt; ?>
				</button>

				<button
					type="button"
					class="button briz-del-media-button <?php echo $delBtnClass; ?>"
					data-action-text="<?php echo $add_action_txt; ?>"
				>
					<?php echo __( 'Удалить медиафайлы' ); ?>
				</button>

				<p><?php _e( $field_params[ 'desc'] ); ?></p>

				<figure>
					<span class="briz-media-place">
<?php
							if ( $field_value ) :
								$value = json_decode( $field_value );
								if ( ! empty( $value ) ) :
									foreach ( $value as $media_id ) :
										$details = wp_prepare_attachment_for_js( $media_id );

										$src = $details[ 'url' ];
										if ( isset( $details[ 'sizes' ][ 'thumbnail' ] ) ) {
											$src = $details[ 'sizes' ][ 'thumbnail' ][ 'url' ];
										}

										if ( $caption = $details[ 'caption' ] ) :
?>
											<figcaption>
												<?php echo $caption; ?>
											</figcaption>
<?php
										endif;

										// Image
										if ( 'image' == $library[ 'type' ] ) :
?>
											<img
												src="<?php echo $src; ?>"
												alt="<?php echo $details[ 'alt' ]; ?>"
											/>
<?php
										// Audio
										elseif ( 'audio' == $library[ 'type' ] ) :
?>
											<audio src="<?php echo $src; ?>" controls></audio>
<?php
										// Video
										elseif ( 'video' == $library[ 'type' ] ) :
?>
											<video src="<?php echo $src; ?>" controls></video>
<?php
										endif;
									endforeach;
								endif;
							endif;
?>
					</span>
				</figure>

				<input
					type="hidden"
					name="<?php echo $field_key; ?>"
					value="<?php echo $field_value ?>"
				/>

				<?php
					// global $wp_meta_boxes;
					// Helper::debug( $wp_meta_boxes );
				?>
			</td>
		</tr>
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

	if ( ! empty( $taxs ) )
		new Term_Meta_Opts( $taxs );
}

add_action( 'admin_init', __NAMESPACE__ . '\\term_meta_opt_init' );
