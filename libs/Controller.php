<?php
/**
 * @author Bruno Martin <brunoocto@gmail.com>
 */

namespace libs;

use \libs\Render;

/**
 * Abstract clas of all Controllers
 * @abstract
 */
abstract class Controller {

	/**
	 * Fallback if no route matches
	 * @param string $method Method of a Class we tried to access
	 * @param array $args Some parameters
	 * @return mixed JSON string output
	 */
	public function __call($method, $args=array()){
		$msg = "Sorry, we could not understand the request.";
		return (new Render)->render($msg, 'json');
	}

	/**
	 * Process the content of a page with variables before to output it
	 * @param string $view The raw format of the page we want to display
	 * @param array $args Some parameters
	 * @return mixed HTML string output
	 */
	public function view($view, $data=array()){
		$brunoaw = \Brunoaw::getInstance();

		//Master view
		$msg = file_get_contents($brunoaw->getPath().'/bundles/web/view/master.html');

		if(is_file($brunoaw->getPath().$view)){

			$msg = str_replace('{{ view }}', file_get_contents($brunoaw->getPath().$view), $msg);
			//Replace HTML variables
			foreach ($data as $key => $value) {
				$msg = str_replace('{{ '.$key.' }}', $value, $msg);
			}
			//Make sure we always load on Front the last updated version of the file
			if(preg_match_all('/(\[\{ (.+?) \}\])/i', $msg, $matches, PREG_SET_ORDER)){
				foreach ($matches as $match) {
					$search = $match[1];
					$file = $match[2];
					$time = time();
					if(is_file($brunoaw->getPath().'/public'.$file)){
						$time = filemtime($brunoaw->getPath().'/public'.$file);
					}
					$file .= '?'.$time;
					$msg = str_replace($search, $file, $msg);
				}
				
			}
		}

		return (new Render)->render($msg, 'html');
	}

}
