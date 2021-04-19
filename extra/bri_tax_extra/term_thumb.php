<?php
namespace Bri_Shortcodes;

class Term_img {
	public $meta_key = 'briz-term-img-id';
	public $default = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAABSUlEQVRoge2aSw6DMAxEe/+zecsFkOAQbKYLZAQ0HyexS+J2JKSoBHteBcEkeRERlmUZ+iAivLgxqogI67ruIPzDaGLPF5DziRF09voBcu/Qq+4egyChjj0p5C0KErvgacU8JUFSFz6hlJcsSC7At5TzIAKRBLKUJLcYRBpQW9KcRSAlgTVUkqsYpDRBrUpzVIHUJLKOXQ1Sm9AqZhNIS2LtWM0grQa0YqiAtBrR+CPUQIA6Q1q3pioIUGZM8/lSBwFkBrVHPBMQIG3UYtg2AwHChq1epKYgwNW4ZTVgDgLsANb12R9EKhe3louH3cXw6+KF6KJEcVE0uijjXXxYufjUdTH54GI6yMUEnYspUxeT2E8uK0zTlO3zOws9PUCw5nmOnhtuMTQG43t5umcIVnbDwAgQrG3bjra/TTUjQrCObU7cGPkgIrwB11J3MEekPv4AAAAASUVORK5CYII=';

	public function __construct( Array $taxs ) {
		$this->add_assets();
		$this->add_hooks( $taxs );
	}

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

	public function add_img_column ( $cols ) {
		$col_name = __( 'Image' );
		return array_slice( $cols, 0, 1 ) + [ 'briz-col-term-img' => $col_name ] + $cols;
	}

	public function fill_img_column ( $str, $col_name, $term_id ) {
		$img_id = ( int ) get_term_meta( $term_id, $this->meta_key, true );

		if ( 'briz-col-term-img' === $col_name && $img_id ) {
			$img_url = wp_get_attachment_image_url( $img_id, [ 60, 60 ] );
			$str = '<img src="' . $img_url . '" />';
		}

		return $str;
	}
}


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
