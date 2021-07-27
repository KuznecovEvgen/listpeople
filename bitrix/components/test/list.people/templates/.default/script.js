$(document).ready(function(){

  $(".close").click(function(){
    $(".modal-wrap").fadeOut();
  });

  $(".add").click(function(){
    $(".modal-wrap").fadeIn();
    $("#type").val("add");
  });

  $('.update').click(function(){
    $(this).removeClass('update');
    $(this).addClass('cencel');
    $(this).html('Отмена');
    $(".save").fadeIn();
    let checks = [];

    $('.checkbox:checked').each(function(){
      let tr_line = $(this).closest('.item');
        tr_line.find('span').each(function(){
          if (!$(this).hasClass("checkbox")) {
            let text_span = $(this).html(),
                attr_name = $(this).attr("name"),
								type = $(this).attr("type");


						if ($(this).find('img').length > 0) {
							$(this).find('img').replaceWith('<input type="file" name="FILE" id="file" class="attach_file">');
						} else {
							$(this).replaceWith("<input type='" + type + "' name='" + attr_name + "' value='" + text_span + "'>");
						}
          }

        });
    });

  });

	$('.save').click(function(){
		$('#upd_form').trigger('submit');
		$(this).fadeOut();
		$(".cencel").addClass('update');
		$(".cencel").html('Изменить');
		$(".cencel").removeClass('cencel');
	});

	$(".delete").click(function(){

		let checks = [],
			type = "delete";

		$('.checkbox:checked').each(function(){
			checks.push($(this).val());
		});

		let msg = 'type='+type+'&elem='+checks;

		$.ajax({
			type: "GET",
			url: "/ajax/sendform.php",
			data: msg,
			success: function(data){
				$(".wrap").load('/index.php .wrap');
			}
		});
	});
});

function sendForm(elem) {
	let form = new FormData(elem);
	let count_file = $("input.attach_file").length;
	if (count_file == 1) {
		let files = $("input.attach_file").files;
		form.append("file", files);
	} else if ( count_file > 1) {
		let files = $("input.attach_file").files
		if (files.length>1) {
			for (var i=0; i<files.length-1; i++) {
				form.append("file_"+i,files[i]);
			}
		}
	}

	$.ajax({
		url: "/ajax/sendform.php",
		dataType: 'HTML',
		type: "POST",
		contentType: false,
    processData: false,
		data: form,
		success: function(data){
			console.log(data);
			$(".modal-wrap").fadeOut();
			$(".wrap").load('/index.php .wrap');
		}
	});
}
