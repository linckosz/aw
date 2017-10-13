<?php
/**
 * @author Bruno Martin <brunoocto@gmail.com>
 */

namespace bundles\web\controllers;

use \bundles\web\models\Data;
use \libs\Controller;
use \libs\Render;

/**
 * Work with models to display only what requested by the front
 */
class ControllerData extends Controller {

	/**
	 * Return the list of all quiz
	 * @return mixed JSON string output
	 */
	public function quiz(){
		$brunoaw = \Brunoaw::getInstance();
		$data = (Data::getData())->quiz;
		return (new Render)->render($data, 'json');
	}

	/**
	 * Tell if the answer is correct or wrong
	 * @return mixed JSON string output
	 */
	public function answer(){
		$brunoaw = \Brunoaw::getInstance();
		$post = $brunoaw->getParam();
		$result = false;
		if(isset($post->id)){
			$items = Data::getData();
			$question_id = false;
			if(isset($items->answer->{$post->id})){
				$question_id = $items->answer->{$post->id}->question_id;
			}
			if($question_id && isset($items->question->$question_id) && $items->question->$question_id->answer_id == $post->id){
				$result = true;
			}
			if($question_id){
				if(!isset($_SESSION['result']) || !is_array($_SESSION['result'])){
					$_SESSION['result'] = array();
				}
				$_SESSION['result'][$question_id] = $post->id;
			}
		}
		return (new Render)->render($result, 'json');
	}

}
