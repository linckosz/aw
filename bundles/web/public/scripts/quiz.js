/**
 * @author Bruno Martin <brunoocto@gmail.com>
 */

//Launch after the DOM is loaded
$(function(){

	//Get all Quizzes
	$.ajax({
		url: '/data/quiz'+'?'+md5(Math.random()),
		type: 'POST',
		data: null,
		contentType: 'application/json; charset=UTF-8',
		success: function(data){
			var item;
			var Elem = null;
			for(var i in data){
				item = data[i];
				//Copy a template, and attach it to the DOM
				Elem = $('#-quiz_model').clone();
				Elem.prop('id', 'quiz_model_'+item['id']);
				Elem.find("[find=title]").html(item['title']);
				Elem.click(
					item['id'],
					function(event){
						event.stopPropagation();
						window.location.href = top.location.protocol+'//'+document.domain+'/show?id='+event.data;
					}
				);
				Elem.appendTo($('#quiz_content'));
			}
			if(Elem){
				Elem.addClass('quiz_model_last');
			}
		},
	});

});
