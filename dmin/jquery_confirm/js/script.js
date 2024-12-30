$(document).ready(function(){

	$('.delete').click(function(){

		var rel = $(this).attr("rel");

		$.confirm({
			'title'		: 'დადასტურების წაშლა',
			'message'	: 'ეს ნივთი წაიშლება. <br />წაშლის შემდგომ აღდგენა შეუძლებელია, დარწმუნებული ხართ რომ გნებავთ წაშლა?',
			'buttons'	: {
				'დიახ'	: {
					'class'	: 'blue',
					'action': function(){
						Location.href = rel;
					}
				},
				'არა'	: {
					'class'	: 'gray',
					'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
				}
			}
		});

	});

});