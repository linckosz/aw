/**
 * @author Bruno Martin <brunoocto@gmail.com>
 */

/**
 * A singleton that will send any JS error to the API to be recordered as a file for the developers
 * @instance
 * @return {void}
 */
var JSerror = new function(){
	this.jsversion = "1.0"; //Javascript version
	this.colourbits = "unknown color bits"; //Color screen depth
	this.yourappalt = navigator.userAgent; //Detailed browser description
	this.javasupport = "Java not supported"; //Java support
	this.yourplatform = navigator.platform; //OS used
	this.youroscpu = "unknown CPU"; //CPU type
	this.yourscreen = screen.width+"("+screen.availWidth+")x"+screen.height+"("+screen.availHeight+")"; //Screen resolution
	this.setting = false;
	var that = this; //Enable to call methods inside other methods

	/**
	 * Send HTTP request
	 * @param {string} message - Error information
	 * @param {string} url - The URL where to send the request
	 * @param {number} linenumber - line where the error occured
	 * @param {number} colnumber - colnum where the error occured
	 * @param {string} error - Error traceability
	 * @return {boolean}
	 */
	this.sendError = function (message, url, linenumber, colnumber, error) {
		if(typeof url == 'undefined'){ url = '';}
		if(typeof linenumber == 'undefined'){ linenumber = 0;}
		if(typeof colnumber == 'undefined'){ colnumber = 0;}
		if(typeof error == 'undefined'){ error = '';}

		if(!this.setting){
			that.setup();
		}

		message = JSON.stringify(message, null, 4);

		var log = "COMP: "+this.yourplatform+" / "+this.youroscpu+" / "+this.colourbits+" / "+this.yourscreen+" / Javascript "+this.jsversion+" / "+this.javasupport+"\nBROW: "+this.yourappalt+"\nLINE: "+linenumber;
		if(typeof colnumber!='undefined' && colnumber!==null){
			log = log+"\nCOL : "+colnumber;
		}
		if(typeof wrapper_localstorage!="undefined" && typeof wrapper_localstorage.user_id!="undefined"){
			log = log+"\nUID : "+wrapper_localstorage.user_id;
		}
		log = log+"\nURL : "+url+"\nMSG : "+message;
		if(typeof error!='undefined' && error!==null && typeof error.stack==='string'){
			log = log+"\nERR : "+error.stack;
		}

		$.ajax({
			url: '/debug/js'+'?'+md5(Math.random()), //We add a random md5 code to insure we avoid getting in queue for the same ajax call
			type: 'POST', //Ajax calls will queue GET request only, that can timeout if the url is the same, but the PHP code still processing in background
			data: JSON.stringify(log),
			contentType: 'application/json; charset=UTF-8',
		});
		console.log(log);

		return true;
	};

	/**
	 * Record some client-side information (safe data) for debugging purpose only
	 * @return {boolean}
	 */
	this.setup = function(){
		var versions = ["1.1", "1.2", "1.3", "1.4", "1.5", "1.6", "1.7", "1.8", "1.9", "2.0+"];
		
		for(i=0; i<versions.length; i++){
			var g = document.createElement('script');
			var s = document.getElementsByTagName('script')[0];
			g.setAttribute("language", "JavaScript" + versions[i]);
			g.text = "JSerror.jsversion='" + versions[i] + "';";
			if(versions[i]=="1.2"){
				g.text = "JSerror.colourbits='" + window.screen.colorDepth + "';";
			}
			s.parentNode.insertBefore(g, s);
			s.parentNode.removeChild(g);
		}

		if(navigator.javaEnabled()){this.javasupport = "Java supported";}

		if(navigator.cpuClass && navigator.cpuClass!="unknown"){
				this.youroscpu = navigator.cpuClass;
		} else if(navigator.oscpu && navigator.oscpu!="unknown"){
			this.youroscpu = navigator.oscpu;
		}

		//Only setup the data once, it's a singleton
		this.setting = true;

		return true;
	}

}

/**
 * Grab any JS error
 * @param {string} message - Error information
 * @param {string} url - The URL where to send the request
 * @param {number} linenumber - line where the error occured
 * @param {number} colnumber - colnum where the error occured
 * @param {string} error - Error traceability
 * @return {boolean}
 */
window.onerror = function(message, url, linenumber, colnumber, error){
	if(typeof colnumber=='undefined'){ colnumber = null; }
	if(typeof error=='undefined'){ error = null; }
	return JSerror.sendError(message, url, linenumber, colnumber, error);
}
