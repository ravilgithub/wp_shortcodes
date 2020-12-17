<?php
/**
 * Plugin Name: BRI Shortcodes Extends
 * Plugin URI:  http://www.yandex.ru
 * Description: BRI Shortcodes Extends
 * Version:     0.0.1
 * Author:      Ravil
 * Author URI:  http://www.tstudio.zzz.com.ua
 */

/*
 * Text Domain: bri_shortcodes_l10n
 * Domain Path: /lang
 */

namespace Bri_Shortcodes;

define( 'PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once 'common/helpers.php';

require_once 'extra/bri_tax_extra/meta_boxes.php';
require_once 'extra/bri_tax_extra/template_select.php';

require_once 'main_class.php';

include_once 'inc/shortcode_bri_list.php';
include_once 'inc/shortcode_bri_dropcap.php';
include_once 'inc/shortcode_bri_highlight.php';
include_once 'inc/shortcode_bri_tooltip.php';
include_once 'inc/shortcode_bri_blockquote.php';
include_once 'inc/shortcode_bri_btn.php';
include_once 'inc/shortcode_bri_link.php';
include_once 'inc/shortcode_bri_image.php';
include_once 'inc/shortcode_bri_separator.php';
include_once 'inc/shortcode_bri_spacer.php';
include_once 'inc/shortcode_bri_message.php';
include_once 'inc/shortcode_bri_tax.php';

/**
 * 
 */
function bri_shortcodes_extends_init() {
	global $bri_shortcodes;
	$bri_shortcodes = array();
	$bri_shortcodes[ 'shortcode_bri_list' ]       = new Bri_List_Shortcode();
	$bri_shortcodes[ 'shortcode_bri_dropcap' ]    = new Bri_Dropcap_Shortcode();
	$bri_shortcodes[ 'shortcode_bri_highlight' ]  = new Bri_Highlight_Shortcode();
	$bri_shortcodes[ 'shortcode_bri_tooltip' ]    = new Bri_Tooltip_Shortcode();
	$bri_shortcodes[ 'shortcode_bri_blockquote' ] = new Bri_Blockquote_Shortcode();
	$bri_shortcodes[ 'shortcode_bri_btn' ]        = new Bri_Btn_Shortcode();
	$bri_shortcodes[ 'shortcode_bri_link' ]       = new Bri_Link_Shortcode();
	$bri_shortcodes[ 'shortcode_bri_image' ]      = new Bri_Image_Shortcode();
	$bri_shortcodes[ 'shortcode_bri_separator' ]  = new Bri_Separator_Shortcode();
	$bri_shortcodes[ 'shortcode_bri_spacer' ]     = new Bri_Spacer_Shortcode();
	$bri_shortcodes[ 'shortcode_bri_message' ]    = new Bri_Message_Shortcode();
	$bri_shortcodes[ 'shortcode_bri_tax' ]        = new Bri_Tax_Shortcode();
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\\bri_shortcodes_extends_init', 99 );
