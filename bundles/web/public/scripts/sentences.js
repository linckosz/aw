/**
 * @author Bruno Martin <brunoocto@gmail.com>
 */

//Launch after the DOM is loaded
$(function(){

	if(sentences_question_picture){
		$('#sentences_content_question_picture')
			.removeClass('divers_display_none')
			.attr('src', sentences_question_picture);
	}

	//Align to center for pictures
	if(sentences_question_style==2){
		$('#sentences_content_answers').addClass('pictures');
	}
	
	var item;
	var Elem = null;
	var num = 0;
	for(var id in sentences_answers){
		item = sentences_answers[id];
		num++;
		//Copy a template, and attach it to the DOM
		if(sentences_question_style==2){
			Elem = $('#-pictures_model').clone();
			Elem.prop('id', 'pictures_model_'+id);
			Elem.find("[find=number]").html(num);
			Elem.css("background-image", "url('"+item+"')");
		} else {
			Elem = $('#-sentences_model').clone();
			Elem.prop('id', 'sentences_model_'+id);
			Elem.find("[find=number]").html(num+')');
			Elem.find("[find=title]").html(item);
		}
		Elem.addClass('sentences_model_hide');
		Elem.click(
			id,
			function(event){
				event.stopPropagation();
				$('.sentences_model_hide').off('click');
				$(this).removeClass('sentences_model_hide').addClass('correct');
				$('.sentences_model_hide').addClass('not_correct');
				answer_check(event.data);
			}
		);
		Elem.appendTo($('#sentences_content_answers'));
	}

});
