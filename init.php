<?php
/**
 * Plugin Name: BRIZ Shortcodes Extends
 * Plugin URI:  http://www.yandex.ru
 * Description: BRIZ Shortcodes Extends
 * Version:     0.0.1
 * Author:      Ravil
 * Author URI:  http://www.tstudio.zzz.com.ua
 */

/*
 * Text Domain: briz_shortcodes_l10n
 * Domain Path: /lang
 */

namespace Briz_Shortcodes;

define( 'PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

require_once 'common/helpers.php';

require_once 'extra/briz_tax_extra/meta/meta.php';
require_once 'extra/briz_tax_extra/meta/term_meta_opts.php';
require_once 'extra/briz_tax_extra/meta/meta_boxes.php';
require_once 'extra/briz_tax_extra/template_select.php';

require_once 'main_class.php';

include_once 'inc/shortcode_briz_list.php';
include_once 'inc/shortcode_briz_dropcap.php';
include_once 'inc/shortcode_briz_highlight.php';
include_once 'inc/shortcode_briz_tooltip.php';
include_once 'inc/shortcode_briz_blockquote.php';
include_once 'inc/shortcode_briz_btn.php';
include_once 'inc/shortcode_briz_link.php';
include_once 'inc/shortcode_briz_image.php';
include_once 'inc/shortcode_briz_separator.php';
include_once 'inc/shortcode_briz_spacer.php';
include_once 'inc/shortcode_briz_message.php';
include_once 'inc/shortcode_briz_tax.php';

/**
 * 
 */
function briz_shortcodes_extends_init() {
	global $briz_shortcodes;
	$briz_shortcodes = array();
	$briz_shortcodes[ 'shortcode_briz_list' ]       = new Briz_List_Shortcode();
	$briz_shortcodes[ 'shortcode_briz_dropcap' ]    = new Briz_Dropcap_Shortcode();
	$briz_shortcodes[ 'shortcode_briz_highlight' ]  = new Briz_Highlight_Shortcode();
	$briz_shortcodes[ 'shortcode_briz_tooltip' ]    = new Briz_Tooltip_Shortcode();
	$briz_shortcodes[ 'shortcode_briz_blockquote' ] = new Briz_Blockquote_Shortcode();
	$briz_shortcodes[ 'shortcode_briz_btn' ]        = new Briz_Btn_Shortcode();
	$briz_shortcodes[ 'shortcode_briz_link' ]       = new Briz_Link_Shortcode();
	$briz_shortcodes[ 'shortcode_briz_image' ]      = new Briz_Image_Shortcode();
	$briz_shortcodes[ 'shortcode_briz_separator' ]  = new Briz_Separator_Shortcode();
	$briz_shortcodes[ 'shortcode_briz_spacer' ]     = new Briz_Spacer_Shortcode();
	$briz_shortcodes[ 'shortcode_briz_message' ]    = new Briz_Message_Shortcode();
	$briz_shortcodes[ 'shortcode_briz_tax' ]        = new Briz_Tax_Shortcode();
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\\briz_shortcodes_extends_init', 99 );
