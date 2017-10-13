<?php
/**
 * @author Bruno Martin <brunoocto@gmail.com>
 */

namespace libs;

/**
 * Application output
 */
class Render {

	/**
	 * Render the page with the appropriate header
	 * @param boolean|string $format We tell in which format the page must be displayed
	 * @return mixed String output
	 */
	public function render($data=null, $format=false){
		ob_clean();
		http_response_code(200);
		
		if($format=='json'){
			header('Content-type: application/json; charset=UTF-8');
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
		} else if($format=='html'){
			header('Content-type: text/html; charset=UTF-8');
			print_r($data);
		} else {
			//Default is plain/text
			header('Content-type: text/plain; charset=UTF-8');
			print_r($data);
		}
		
		session_write_close();
		return exit(0);
	}
	
}
