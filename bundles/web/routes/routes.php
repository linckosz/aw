<?php
/**
 * @author Bruno Martin <brunoocto@gmail.com>
 */

namespace bundles\web\routes;

$brunoaw = \Brunoaw::getInstance();



//For SDK JS demo page
$brunoaw->setRouteGet('/', '\bundles\web\controllers\ControllerQuiz', 'quiz');

//Display the question with its answers
$brunoaw->setRouteGet('/show', '\bundles\web\controllers\ControllerQuiz', 'show');



//For debugging
$brunoaw->setRoutePost('/debug/test', '\bundles\web\controllers\ControllerDebug', 'test');
$brunoaw->setRoutePost('/debug/js', '\bundles\web\controllers\ControllerDebug', 'js');

//List of quiz
$brunoaw->setRoutePost('/data/quiz', '\bundles\web\controllers\ControllerData', 'quiz');

//Check if an answer is correct
$brunoaw->setRoutePost('/data/answer', '\bundles\web\controllers\ControllerData', 'answer');
