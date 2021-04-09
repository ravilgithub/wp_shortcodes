<?php
namespace Bri_Shortcodes;

class Term_img {
	public $holder = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkAQMAAABKLAcXAAAABlBMVEUAAAC7u7s37rVJAAAAAXRSTlMAQObYZgAAACJJREFUOMtjGAV0BvL/G0YMr/4/CDwY0rzBFJ704o0CWgMAvyaRh+c6m54AAAAASUVORK5CYII=';

	public function __construct( Array $taxs ) {
		$this->add_hooks( $taxs );
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
		
	}

	public function edit_term_img ( $term ) {
		
	}

	public function save_term_img ( $term_id ) {
		
	}

	public function add_img_column ( $cols ) {
		
	}

	public function fill_img_column ( $str, $col_name, $term_id ) {
		
	}
}


function term_img_init() {
	$taxs = [
		'category',
		'product_cat'
	];

	$taxs = add_filter( 'BRI_Term_img_atts', $taxs );

	if ( ! empty( $taxs ) )
		new Term_img( $taxs );
}

add_action( 'admin_init', __NAMESPACE__ . '\\term_img_init');
