jQuery(document).ready(function($){


	$('.cmb2_select').change(function(){
		var data = {
			'action': 'my_action',
			'post_var': $(this).val()
		};

		 jQuery.post(ajaxurl, data, function(response) {
		 	alert('Got this from the server: ' + response);
		 	console.log(response);
		 });
	});
	console.log('ready');
});
