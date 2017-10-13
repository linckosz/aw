<?php
/**
 * @author Bruno Martin <brunoocto@gmail.com>
 */

namespace bundles\web\models;

/**
 * Class of Models
 * This part is simplified by using a hardcoded json file, but ideally it should be split into several models correspending to database tables' name
 */
class Data {

	/**
	 * Return the whole list of models as an object
	 * @return object
	 */
	public static function getData(){
		$brunoaw = \Brunoaw::getInstance();
		$content = file_get_contents($brunoaw->getPath().'/bundles/web/models/data.json');
		return json_decode($content);
	}

}
