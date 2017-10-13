/**
 * @author Bruno Martin <brunoocto@gmail.com>
 */

//Delete URI
//window.history.replaceState(null, null, document.location.pathname);

/**
 * If the variable is an array/object, it will recusively force to convert it into an object
 * it can avoid array bug [0, undefined, undefined, 3, 4] that can generated tons of unecessary calculations
 * @param {*} arr - Any variable that can be converted into an object
 * @return {string}
 */
var ArrayToObject = function(arr){
	var result = false;
	if(typeof arr == 'object'){
		result = {};
		for(var i in arr){
			result[i] = ArrayToObject(arr[i]);
		}
	} else {
		result = arr;
	}
	return result;
};

/**
 * Help to know if the device has touch capabiliy
 */
var supportsTouch = 'ontouchstart' in window || navigator.msMaxTouchPoints;


/**
 * Help to display HTML text for a JS variable
 * @param {string} text - Any text
 * @return {string}
 */
var parseHTML = function(text) {
	text = ''+text;
	return text
		.replaceAll('<', '&lt;')
		.replaceAll('>', '&gt;')
		.replaceAll('"', '&quot;')
		.replaceAll("'", '&#39;')
		.replaceAll('  ', '&nbsp;&nbsp;')
	;
};

/**
 * Help to display HTML text for a JS variable, and convert line breaks
 * @param {string} text - Any text
 * @return {string}
 */
var JStoHTML = function(text){
	//text = php_htmlentities(text, true); //Need to enable double encoding
	if(typeof text == 'undefined'){
		text = '';
	}
	text = parseHTML(text);
	text = lnTobr(text);
	return text;
};

/**
 * Convert line break into DOM element BR
 * @param {string} text - Any text
 */
var lnTobr = function(str) {
	return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br />$2');
};

/**
 * Replace all instance found in a string
 * @param {string} find - The search string
 * @param {string} replace - The replacement string 
 * @return {string}
 */
String.prototype.replaceAll = function(find, replace) {
	find = find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
	return this.replace(new RegExp(find, 'gi'), replace);
};

/**
 * Launch a debugger for PHP
 * @param {*} data - Any kind of data that can be stringified
 * @return {void}
 */
var sendTest = function(data){
	if(typeof data == 'undefined'){
		data = null;
	}
	$.ajax({
		url: '/debug/test'+'?'+md5(Math.random()), //We add a random md5 code to insure we avoid getting in queue for the same ajax call
		type: 'POST', //Ajax calls will queue GET request only, that can timeout if the url is the same, but the PHP code still processing in background
		data: JSON.stringify(data),
		contentType: 'application/json; charset=UTF-8',
	});
}
