<?php
/**
 * Zend Loader class
 *
 * This class will help you load classes from Zend Framework.
 *
 * @copyright     David Gallagher
 * @link          http://github.com/thegallagher/ZendLoader
 * @license       MIT (http://www.opensource.org/licenses/mit-license.php)
 */

class ZendLoader {
	
/**
 * Classes which have already been loaded.
 *
 * @var array
 */
	protected static $_loadedClasses = array();
	
/**
 * Vendor paths which have been added to the include path.
 *
 * @var array
 */
	protected static $_loadedPlugins = array();

/**
 * Load a Zend Framework class.
 * 
 * The Zend package you want to load from needs to be in the Vendor folder
 * for the app or plugin. eg. /app/Vendor/Zend/Json
 *
 * Usage:
 *
 * `ZendLoader::load('Zend/Json'); will load Zend_Json class.`
 *
 * `ZendLoader::load('Plugin.Zend/Json'); will load Zend_Json class from a plugin.`
 *
 * @param string $name The name of the class to load.
 * @return mixed The name of the class loaded if successful or otherwise false.
 */
	public static function load($name) {
		list($plugin, $class) = pluginSplit($name);

		if (!in_array($class, self::$_loadedClasses)) {
			// Add the Vendor folder to PHP's include path.
			if (!in_array($plugin, self::$_loadedPlugins)) {
				$path = App::path('Vendor', $plugin);
				set_include_path(get_include_path() . PATH_SEPARATOR . $path[0]);
				self::$_loadedPlugins[] = $plugin;
			}
			
			// Attempted to load the class
			$loaded = App::import('Vendor', $name);
			if (!$loaded) {
				return false;
			}
			self::$_loadedClasses[] = $class;
		}
		return str_replace('/', '_', $class);
	}

}