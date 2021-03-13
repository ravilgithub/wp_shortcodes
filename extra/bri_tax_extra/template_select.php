<?php
namespace Bri_Shortcodes;

/**
 * The class adds a selection of available templates for the terms being created or modified.
 *
 * Класс добавляет выбор доступных шаблонов для создаваемых или изменяемых терминов.
 *
 * @property Array $files - опции( имена файлов ) выпадающего списка позволяющий 
 *                          выбрать нужный шаблон для записей термина.
 * @property String $dir - директория шаблонов.
 *
 * @since 0.0.1
 * @author Ravil
 */
class Tax_TMPL extends Meta_boxes {
	public $files = [ 'None' => -1 ];
	public $dir;


	/**
	 * Constructor.
	 *
	 * @param String $dir - директория шаблонов.
	 * @param Array $taxs - таксономии к терминам которых добавляется возможность выбора шаблона.
	 *
	 * @return void.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function __construct( $dir, Array $screens, Array $taxs ) {
		parent::__construct( $screens, $taxs );
		$this->dir = $dir;
		$this->get_tmpl();
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
			// Helper::debug( $tax_name, '200px' );

			// Поля при добавлении элемента( термина ) таксономии.
			add_action( "{$tax_name}_add_form_fields", [
				$this,
				'bri_add_term_template_select'
			] );

			// Поля при редактировании элемента( термина ) таксономии.
			add_action( "{$tax_name}_edit_form_fields", [
				$this,
				'bri_edit_term_template_select'
			] );

			// Сохранение при добавлении элемента( термина ) таксономии.
			add_action( "create_{$tax_name}", [
				$this,
				'bri_save_term_template_select'
			] );

			// Сохранение при редактировании элемента( термина ) таксономии.
			add_action( "edited_{$tax_name}", [
				$this,
				'bri_save_term_template_select'
			] );
		}
	}


	/**
	 * Retrieving template file names.
	 *
	 * Получаем имена файлов шаблонов.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function get_tmpl() {
		$tmpls_path = plugin_dir_path( __FILE__ ) . $this->dir;
		$tmpls_path = apply_filters( "bri_tax_tmpl_path", $tmpls_path );

		// Helper::debug( $tmpls_path, '200px' );

		$it = new \RecursiveIteratorIterator( 
			new \RecursiveDirectoryIterator( $tmpls_path )
		);

		foreach ( $it as $obj ) {
			if ( ! $it->isDot() ) {
				extract( pathinfo( $obj ) );

				if ( 'php' != $extension )
					continue;

				$this->files[ $filename ] = "{$dirname}/{$basename}";
			}
		}

		// Helper::debug( $this->files, '200px' );
	}


	/**
	 * Adding additional form fields for taxonomy terms when creating them.
	 *
	 * Добавляем дополнительные поля формы терминов таксономии при их создании.
	 *
	 * @param String $taxonomy_slug - ярлык таксономии.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function bri_add_term_template_select( $taxonomy_slug ) {
?>
		<div class="form-field">
			<label for="tmpl">
				<?php _e( 'Termin template' ); ?>
			</label>

			<select name="tmpl" id="tmpl">

				<?php foreach( $this->files as $file_name => $path ) : ?>
					<option value="<?php echo $path ?>">
						<?php _e( $file_name ); ?>
					</option>
				<?php endforeach; ?>

			</select>

			<p class="description">
				<?php _e( 'Шаблон, согласно которому будет формироваться вывод категории и записей относящихся к ней.' ); ?>
			</p>
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
	public function bri_edit_term_template_select( $term ) {
?>
		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="tmpl">
					<?php _e( 'Termin template' ); ?>
				</label>
			</th>
			<td>

				<select id="tmpl" name="tmpl">

					<?php foreach( $this->files as $file_name => $path ) : ?>
						<option
							value="<?php echo $path; ?>"
							<?php
								selected(
									$path,
									esc_attr( get_term_meta( $term->term_id, 'tmpl', 1 ) )
								);
							?>
						>
							<?php _e( $file_name ); ?>
						</option>
					<?php endforeach; ?>

				</select>

				<p class="description">
					<?php _e( 'Шаблон, согласно которому будет формироваться вывод категории и записей относящихся к ней.' ); ?>
				</p>
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
	 * @return Integer $term_id - id сохраняемого термина.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function bri_save_term_template_select( $term_id ) {
		if ( ! isset( $_POST[ 'tmpl' ] ) ) return;
		if ( ! current_user_can( 'edit_term', $term_id ) ) return;
		if (
			// wp_nonce_field( 'update-tag_' . $tag_ID );
			! wp_verify_nonce( $_POST['_wpnonce'], "update-tag_$term_id" ) &&
			// wp_nonce_field('add-tag', '_wpnonce_add-tag');
			! wp_verify_nonce( $_POST['_wpnonce_add-tag'], 'add-tag' )
		) return;

		// Все ОК! Теперь, нужно сохранить/удалить данные

		// очистка
		$val = sanitize_text_field( wp_unslash( $_POST[ 'tmpl' ] ) );

		// сохранение
		if( ! $val )
			delete_term_meta( $term_id, 'tmpl' );
		else
			update_term_meta( $term_id, 'tmpl', $val );

		return $term_id;
	}
}


/**
 * Initializing Class Tax_TMPL.
 *
 * Инициализация класса Tax_TMPL.
 *
 * @return void
 *
 * @since 0.0.1
 * @author Ravil
 */
function tax_tmpl_init() {
	$atts = [
		'tmpls_dir'  => 'tax_tmpl',
		'screens'    => [ 'post', 'product' ],
		'taxonomies' => [ 'category', 'product_cat' ]
	];

	$atts = apply_filters( 'BRI_Tax_TMPL_Atts', $atts );

	if ( empty( $atts ) )
		return;

	extract( $atts );
	$tax_tmpl = new Tax_TMPL( $tmpls_dir, $screens, $taxonomies );
}

add_action( 'admin_init', __NAMESPACE__ . '\\tax_tmpl_init' );
