<?php
/**
 * @author Bruno Martin <brunoocto@gmail.com>
 */

use \libs\Folder;
use \libs\Render;
use \libs\SQL;
use \libs\STR;

/**
 * A class to store and operation all general application information
 */
class Brunoaw {

	/**
	 * The singleton of the running application
	 * @access protected
	 * @static
	 */
	protected static $singleton = null;

	/**
	 * Store any kind of data, for a global access
	 * @access protected
	 * @static
	 */
	protected static $data = array();

	/**
	 * The root directory of the application
	 * @access protected
	 * @static
	 */
	protected static $path = null;

	/**
	 * Keep a record of the data sent via POST or GET
	 * @access protected
	 * @static
	 */
	protected static $param = null;

	/**
	 * All routes accepted
	 * @access protected
	 * @static
	 */
	protected static $route = array(
		'GET' => array(),
		'POST' => array(),
	);

	/**
	 * Constructor
	 * @access protected
	 * @return void
	 */
	protected function __construct(){
		if(!self::$singleton){
			self::$path = dirname(__FILE__);
			self::$singleton = $this;
			self::getParam();
		}
	}

	/**
	 * Return the application instance
	 * @static
	 * @return self
	 */
	public static function getInstance(){
		if(self::$singleton){
			return self::$singleton;
		}
		return new self;
	}

	/**
	 * Return the data sent via GET or POST
	 * @static
	 * @return object
	 */
	public static function getParam(){
		if(self::$param){
			return self::$param;
		}
		if(mb_strtolower($_SERVER['REQUEST_METHOD'])=='post'){
			self::$param = $_POST;
		} else if(mb_strtolower($_SERVER['REQUEST_METHOD'])=='get'){
			self::$param = $_GET;
		}
		//Force to object convertion
		self::$param = json_decode(json_encode(self::$param, JSON_FORCE_OBJECT));
		return self::$param;
	}

	/**
	 * Check if a data exists in the application instance
	 * @param string $key The key array
	 * @return boolean
	 */
	public function checkData($key){
		if(is_string($key) && isset(self::$data[$key])){
			return true;
		}
		return false;
	}

	/**
	 * Return a data stored in the application instance
	 * @param string $key The key array
	 * @return mixed
	 */
	public function getData($key){
		if(is_string($key) && self::checkData($key)){
			return self::$data[$key];
		}
		return null;
	}

	/**
	 * Set a data stored in the application instance
	 * @param string $key The key array
	 * @param mixed $value The value to attach
	 * @return mixed
	 */
	public function setData($key, $value){
		return self::$data[$key] = $value;
	}

	/**
	 * Return the root directory of the application
	 * @return string
	 */
	public function getPath(){
		return self::$path;
	}

	/**
	 * Load all bundles requested
	 * @param string[] $bundles An array of bundles's string
	 * @return void
	 */
	public function loadBundles(array $bundles){
		//Make sure that /public/brunoaw exists and has the Write right by apache
		foreach ($bundles as $bundle) {
			//Only accept routes from preloaded bundles
			$folder = new Folder($this->getPath().'/bundles/'.$bundle.'/routes');
			$folder->includeRecursive();

			//Include public files (create symlink at first launch only)
			if(is_dir($this->getPath().'/bundles/'.$bundle.'/public') && !is_dir($this->getPath().'/public/brunoaw/'.$bundle)){
				$folder = new Folder();
				$folder->createSymlink($this->getPath().'/bundles/'.$bundle.'/public', $this->getPath().'/public/brunoaw/'.$bundle);
			}
		}
	}

	/**
	 * Set a GET route access
	 * @param string $uri Current URI
	 * @param string $controller Controller class name
	 * @param string $function Controller method name
	 * @return void
	 */
	public function setRouteGet(string $uri, string $controller, string $function){
		self::$route['GET'][$uri] = array($controller, $function);
	}

	/**
	 * Set a POST route access
	 * @param string $uri Current URI
	 * @param string $controller Controller class name
	 * @param string $function Controller method name
	 * @return void
	 */
	public function setRoutePost(string $uri, string $controller, string $function){
		self::$route['POST'][$uri] = array($controller, $function);
	}

	/**
	 * Start the application
	 * @return mixed boolean / JSON string output
	 */
	public function launch(){
		$uri = strstr($_SERVER['REQUEST_URI'], '?', true); //Exclude everything after '?'
		if(!$uri){
			$uri = $_SERVER['REQUEST_URI'];
		}
		$method = $_SERVER['REQUEST_METHOD'];
		if(isset(self::$route[$method])){
			if(isset(self::$route[$method][$uri]) && class_exists(self::$route[$method][$uri][0], true)){
				$controller = new self::$route[$method][$uri][0];
				if(method_exists($controller, self::$route[$method][$uri][1])){
					$controller->{self::$route[$method][$uri][1]}();
					return true;
				}
			}
		}
		$msg = 'Sorry, we could not understand the request.';
		return (new Render)->render($msg, 'json');
	}

}

/**
 * Initiate the singleton
 */
$brunoaw = \Brunoaw::getInstance();
