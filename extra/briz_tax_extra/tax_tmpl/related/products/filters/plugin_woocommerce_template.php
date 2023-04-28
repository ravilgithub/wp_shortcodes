<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\tax_tmpl\related\products\filters;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Briz_Shortcodes\common\Helper;


/**
 * Redefining Woocommerce Template.
 *
 * Переопределение Woocommerce шаблона.
 *
 * @since 0.0.1
 * @author Ravil
 */
trait PluginWoocommerceTemplate {

	/**
	 * Using a Woocommerce Template from a Plugin.
	 *
	 * Использование Woocommerce шаблона из плагина.
	 *
	 * @param String $template - Абсолютный путь до шаблона.
	 * @param String $template_name - Относительный путь до шаблона (woocommerce/template_path)
	 * @param String $template_path - Директория шаблонов (woocommerce/)
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public static function set_template_path( $template, $template_name, $template_path ) {
		// $template - /home/ravil/web/wordpress/www/clear/wp-content/themes/blank/woocommerce/single-product/sale-flash.php
		// template_name - single-product/sale-flash.php
		// template_path - woocommerce/
		// Helper::debug( $template_path );

		global $woocommerce;

		if ( ! $template_path )
			$template_path = $woocommerce->template_url;

		$plugin_path  = PLUGIN_PATH . $template_path;
		if ( file_exists( $plugin_path . $template_name ) )
			$template = $plugin_path . $template_name;

		return $template;
	}
}
