/**
 * @author Bruno Martin <brunoocto@gmail.com>
 */

//Launch after the DOM is loaded
$(function(){

	$('#result_home').click(function(event){
		event.stopPropagation();
		window.location.href = top.location.protocol+'//'+document.domain;
	})

	for(var i in result_questions){
		Elem = $('#-result_model').clone();
		Elem.prop('id', 'result_model_'+i);
		Elem.find("[find=question]").html(result_questions[i]['title']);
		if(result_questions[i]['style']==2){ //For pictures
			Elem.find("[find=picture]")
				.attr("src", result_questions[i]['answer'])
				.removeClass('divers_display_none');
		} else {
			Elem.find("[find=answer]")
				.html(result_questions[i]['answer'])
				.removeClass('divers_display_none');
		}
		if(result_questions[i]['result']){
			//Correct answer
			Elem.find("[find=result]").addClass('fa fa-check correct');
		} else {
			//Wrong answer
			Elem.find("[find=result]").addClass('fa fa-times not_correct');
		}
		Elem.appendTo($('#result_content_list'));

		//Add a sepration line (because it's rows)
		Elem = $('#-line_model').clone();
		Elem.prop('id', 'line_model_'+i);
		Elem.appendTo($('#result_content_list'));
	}

});
