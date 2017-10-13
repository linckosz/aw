<?php
/**
 * @author Bruno Martin <brunoocto@gmail.com>
 */

namespace bundles\web\controllers;

use \libs\Controller;
use \libs\Render;
use \libs\Folder;
use \libs\STR;
use \bundles\web\models\data\Quiz;
use \bundles\web\models\data\Question;

/**
 * Grab outside debugging information
 */
class ControllerDebug extends Controller {

	//This function help to test some code scenario
	/**
	 * Record JS code sent by the client
	 * @return mixed JSON string output
	 */
	public function js(){
		\libs\Watch::js();
		return (new Render)->render('debug', 'json');
	}

	/**
	 * You can write everything you need to test/debug
	 * From client side, launch it with the javascript ajax:
	 * commmunication_ajax.send('/test');
	 * @return mixed JSON string output
	 */
	public function test(){
		$brunoaw = \Brunoaw::getInstance();
		$tp = null;

		//Do your cook here

		\libs\Watch::php( $tp, time(), __FILE__, __LINE__, false, false, true);
		return (new Render)->render('test', 'json');
	}

}
