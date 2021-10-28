<?php
namespace Briz_Shortcodes\extra\briz_tax_extra\meta;
use Briz_Shortcodes\common\Helper;

/**
 * The class implements the general functionality of meta fields.
 *
 * Класс реализует общий функционал мета полей.
 *
 * @property String $assets_id - префикс id, JS и CSS файлов.
 * @property String $inc_path  - путь к HTML компонентам - мета полям.
 * 
 * @since 0.0.1
 * @author Ravil
 */
abstract class Meta {
	protected $assets_id = 'briz_meta';
	protected $inc_path = PLUGIN_PATH . 'extra/briz_tax_extra/meta/inc/';

	/**
	 * Constructor.
	 *
	 * @return void.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	protected function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'add_assets' ] );
		$this->redefine_script_tag();
	}


	/**
	 * Add CSS and JS.
	 *
	 * Добавление стилей и скриптов.
	 *
	 * @return void.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function add_assets() {
		$assets = [
			'css' => [
				/************ CSS ************/
				[
					'id'   => $this->assets_id . '-css',
					'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/css/' . $this->assets_id . '.min.css',
					'deps' => [],
					'ver'  => '1.0.0'
				]
			],
			'js' => [
				/************ SCRIPTS ************/
				[
					'id'   => $this->assets_id . '-js',
					'src'  => PLUGIN_URL . 'extra/briz_tax_extra/assets/js/' . $this->assets_id . '.js',
					'deps' => [ 'jquery' ],
					'ver'  => '1.0.0',
					'in_footer' => true
				]
			]
		];

		$assets = apply_filters( "{$this->assets_id}_assets", $assets );
		Helper::join_assets( $assets, false );
	}


	/**
	 * Adding a filter to override the attributes of the 'script' tag.
	 *
	 * Добавление фильтра для переопределения атрибутов тега 'script'.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 * */
	public function redefine_script_tag() {
		add_filter( 'script_loader_tag', [ $this, 'set_module_attr' ], 10, 3 );
	}


	/**
	 * We indicate that the script is a module and, accordingly
	 * will be able to import
	 * functionality from other modules.
	 *
	 * Указываем, что скрипт - это модуль и соответственно
	 * будет иметь возможность импортировать
	 * функционал из других модулей.
	 *
	 * @param String $tag    - HTML код тега <script>.
	 * @param String $handle - Название скрипта (рабочее название),
	 *                         указываемое первым параметром в
	 *                         функции wp_enqueue_script().
	 * @param String $src    - Ссылка на скрипт.
	 *
	 * @return String $tag   - HTML код тега <script>.
	 *
	 * @since 0.0.1
	 * @author Ravil
	 * */
	public function set_module_attr( $tag, $handle, $src ) {
		$module_handle = $this->assets_id . '-js';
		if ( $module_handle === $handle )
			$tag = '<script type="module" src="' . $src . '" id="' . $module_handle . '-js"></script>';
		return $tag;
	}


	/**
	 * Connecting the HTML component of the meta field.
	 *
	 * Подключение HTML комонента мета поля.
	 *
	 * @param Array $params - параметры мета поля.
	 * @param String $key   - имя мета поля.
	 * @param String $value - значение мета поля.
	 * @param String $method_suffix - суффикс названия подключаемого компонента.
	 *                                Possible: '' | '_edit'
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 * @author Ravil
	 */
	public function require_component( $key, $value, $params, $component_suffix, $saved ) {
		$component_name = $params[ 'type' ] . $component_suffix;
		$component_path = $this->inc_path . $component_name . '.php';
		$filter_id = 'briz_meta_' . $component_name . '_component';

		ob_start();
		require apply_filters( $filter_id, $component_path, $key, $value, $params, $component_suffix, $saved );
		return ob_end_flush();
	}
}
