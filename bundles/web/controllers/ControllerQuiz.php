<?php
/**
 * @author Bruno Martin <brunoocto@gmail.com>
 */

namespace bundles\web\controllers;

use \bundles\web\models\Data;
use \libs\Controller;

/**
 * Main page Controller
 */
class ControllerQuiz extends Controller {

	/**
	 * Display the Quiz page
	 * @return void
	 */
	public function quiz(){
		//We reset the result list
		$_SESSION['quiz_id'] = false;
		$_SESSION['page'] = 1;
		$_SESSION['result'] = array();
		$this->view('/bundles/web/view/quiz.html');
	}

	/**
	 * Display the Question or  the Result
	 * @return boolean
	 */
	public function show(){
		$brunoaw = \Brunoaw::getInstance();
		$get = $brunoaw->getParam();

		$quiz_id = false;
		if(isset($get->id)){
			$quiz_id = $get->id;
		} else if(isset($_SESSION['quiz_id'])){
			$quiz_id = $_SESSION['quiz_id'];
		}

		if($quiz_id){
			//If the Quiz ID is different, we reset the result list
			if(
				   !isset($_SESSION['quiz_id'])
				|| !isset($_SESSION['page'])
				|| !isset($_SESSION['result'])
				|| $_SESSION['quiz_id'] != $quiz_id
			){
				$_SESSION['quiz_id'] = $quiz_id;
				$_SESSION['page'] = 1;
				$_SESSION['result'] = array();
			}

			$data = Data::getData();

			$question = false;

			//Get the question
			if(isset($data->quiz->$quiz_id)){
				$count = $_SESSION['page'];
				foreach ($data->question as $item) {
					if($item->quiz_id == $quiz_id){
						$question = $item;
						$count--;
					}
					if($count<=0){
						break;
					}
				}
				//If the count is > 0, it means that we finish all questions, and we can display the result
				if($count>0){
					//Display all questions with their correct answer and the user result
					$total_nbr_questions = 0; //Total numbers of question
					$total_nbr_correct = 0; //Total numbers of correct answer
					$questions = new \stdClass;
					foreach ($data->question as $item) {
						if($item->quiz_id != $quiz_id){
							continue;
						}
						$total_nbr_questions++;
						$questions->{$item->id} = new \stdClass;
						$questions->{$item->id}->title = $item->title;
						$questions->{$item->id}->style = $item->style;
						$questions->{$item->id}->result = false;
						$questions->{$item->id}->answer = '';
						//Grab the answer information
						if(isset($data->answer->{$item->answer_id})){
							if(
								   isset($_SESSION['result'])
								&& isset($_SESSION['result'][$item->id])
								&& $item->answer_id == $_SESSION['result'][$item->id]
							){
								$total_nbr_correct++;
								$questions->{$item->id}->result = true;
							}
							if($item->style==2){ //For pictures
								$questions->{$item->id}->answer = $data->answer->{$item->answer_id}->picture;
							} else { //For sentences
								$questions->{$item->id}->answer = $data->answer->{$item->answer_id}->title;
							}
						}
					}
					$evaluation = round(100*$total_nbr_correct/$total_nbr_questions); //Give an evaluation on 5 points (0-25-50-75-100)
					$comment = '';
					
					//Round the evaluation
					if($evaluation >= 100){
						$evaluation = 100;
						$comment = 'Perfect!';
					} else if($evaluation >= 75){
						$evaluation = 75;
						$comment = 'You\'re Awesome!';
					} else if($evaluation >= 50){
						$evaluation = 50;
						$comment = 'So so...';
					} else if($evaluation >= 25){
						$evaluation = 25;
						$comment = '😵 😵 😵';
					} else {
						$evaluation = 0;
						$comment = 'Seriously!?!';
					}

					$data = array(
						'quiz_title' => $data->quiz->$quiz_id->title,
						'comment' => $comment,
						'evaluation' => $evaluation,
						'questions' => json_encode($questions),
					);
					$this->view('/bundles/web/view/result.html', $data);
					return true;
				}
			}
			//Increment to display the next page if the user refresh the page (avoid hack)
			$_SESSION['page']++;

			$answers = new \stdClass;
			if($question){
				//Get all answers
				foreach ($data->answer as $item) {
					if($item->question_id == $question->id){
						if($question->style==1){
							$answers->{$item->id} = $item->title;
						} else {
							$answers->{$item->id} = $item->picture;
						}
					}
				}

				$data = array(
					'question_title' => $question->title,
					'question_picture' => $question->picture,
					'question_style' => $question->style,
					'answers' => json_encode($answers),
				);
				$this->view('/bundles/web/view/sentences.html', $data);
				return true;
			}

		}

		$this->quiz();
		return true;
	}

}
