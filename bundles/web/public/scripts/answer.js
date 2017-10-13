/**
 * @author Bruno Martin <brunoocto@gmail.com>
 */

/**
 * Display the result to the user
 * @param {number} answer_id - Answer ID
 * @return {void}
 */
var answer_check = function(answer_id){
	//Check the answer
	$.ajax({
		url: '/data/answer'+'?'+md5(Math.random()),
		type: 'POST',
		data: JSON.stringify({id: answer_id}),
		contentType: 'application/json; charset=UTF-8',
		success: function(data){
			//Display the overlay box to inform the user about result
			var answer_count = 3;
			var answer_count_timer = false
			$('#answer').removeClass('divers_display_none');
			answer_count_timer = setInterval(function(result){
				answer_count--;
				if(answer_count==0){
					clearInterval(answer_count_timer);
					$("#answer_count").addClass('divers_display_none');
					$("#answer_info, #answer_next").removeClass('divers_display_none');
					if(result){
						$("#answer_info").html("correct!");
						$("#answer_image_1").removeClass('divers_display_none');
					} else {
						$("#answer_info").html("not the one that I think is correct 😉");
						$("#answer_image_0").removeClass('divers_display_none');
					}
				} else {
					$("#answer_count").html(answer_count);
				}
			}, 1000, data);

		},
	});
};

$(function(){
	$('#answer_next').click(function(event){
		event.stopPropagation();
		window.location.href = top.location.protocol+'//'+document.domain+'/show';
	});
});
