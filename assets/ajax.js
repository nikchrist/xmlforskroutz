( function($){
	var checkbox = $('.regular-checkbox');
	if( checkbox.val() == "true")
	{
		$('#successmes2').html('<div id="var-message">Variations are enabled</div>');
	} else {
		$('#successmes2').html('<div id="var-message">Variations are disabled</div>');
	}
$(document).on("click",".runbtnclass",function(event){ 
	event.preventDefault();

	$.ajax({
		type: 'post',
		dataType: 'json',
		url: myjs_globals.ajax_url,
		data: {
			action: 'myjs_for_skroutz',
			_ajax_nonce_: myjs_globals.nonce
		},
		success: function(response)
		{
				response.custom;
				$('#successmes').html('<h2>XML CREATED!!!</h2>').fadeIn('fast');
				$('#successmes').fadeOut('slow');
				
		}
		});

 });
	
})(jQuery)