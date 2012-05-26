jQuery(document).ready(function(){
	jQuery("#login-form").submit(function(){
		var data = jQuery(this).serialize();
		jQuery.post("/owners/process-login", data, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				window.location.href = "/owners";
			}
		});
		return false;
	});
});