$(document).ready(function(){

	$('.delete').click(function(e){
		var rel = $(this).attr("rel");
		$.confirm({
			'title': 'დამტკიცება წაშლის',
			'message': 'წაშლილს შემდგომ აღდგენა შეუძლებელი იქნება! წავშალოთ?',
			'buttons': {
				'კი': {
					'class': 'blue',
					'action': function(){
						location.href = rel;
					}
				},
				'არა': {
					'class': 'gray',
					'action': function(){}
				}
			}
		});
	});
	$('#select-links').click(function(){
		$('#list-links,#list-links-sort').slideToggle(200);
	});
	$('.h3click').click(function(){
		$(this).next().slideToggle(400);
	});

	var count_input = 1;
	$('#add-input').click(function(){
		count_input++;
		$('<div id="addimage'+count_input+'" class="addimage">'+
			'<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />'+
			'<input type="file" name="galleryimg[]" />'+
			'<a class="delete-input" rel="'+count_input+'" >წაშლა</a></div>').fadeIn(300).appendTo('#objects');
	});


	// dinamikuri suratis input cashla

	$(document).on('click','.delete-input',function(){

		var rel = $(this).attr("rel");

		$("#addimage"+rel).fadeOut(300,function(){
			$("#addimage"+rel).remove();
		});

	});

	//suratis cashla galeriidan mtavari
	$('.del-img').click(function(){
		var img_id = $(this).attr("img_id");
		var title_img = $("#del"+img_id+" > img").attr("title");

		$.ajax({
			type: "POST",
			url: "actions/delete-gallery.php",
			data: "id="+img_id+"&title="+title_img,
			dataType: "html",
			cache: false,
			success: function(data) {
				if(data == "delete") {
					$("#del"+img_id).fadeOut(300);
				}
			}
		});
	});
	/**
	 * vshlit kategorias select - option
	 */
	$('.delete-cat').click(function(){
		var select_id = $('#cat_type option:selected').val();
		if(!select_id) {
			$('#cat_type').css('borderColor', '#f5a4a4');
		} else {
			$.ajax({
				type: 'POST',
				url: 'actions/delete-category.php',
				data: 'id='+select_id,
				dataType: 'html',
				cache: false,
				success: function(data) {
					if(data == 'delete') {
						$('#cat_type option:selected').remove();
					}
				}
			});
		}
	});
	/**
	 * moxmareblebis fanjris gaxsna daxurva
	 */
	$('.block-clients').click(function(e){
		e.preventDefault();
		$(this).find('ul').slideToggle(300);
	});

	/**
	 * Сокрытие или отображение модального окна
	 * добавления новости
	 */
	$(".news").fancybox();
	/**
	 * privilegiaebis monishvna an moxsna
	 */
	$('#select-all').click(function(){
		$('.privilege input:checkbox').attr('checked', true);
	});
	$('#remove-all').click(function(){
		$('.privilege input:checkbox').attr('checked', false);
	});
});


