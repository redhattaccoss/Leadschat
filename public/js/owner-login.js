jQuery(document).ready(function(){
	jQuery.get("/owners/islogin", function(data){
		data = jQuery.parseJSON(data);
		if (data.result){
			window.location.href = "/owners";
		}
	});
	
	jQuery("#login-form").submit(function(){
		var data = jQuery(this).serialize();
		jQuery.post("/owners/process-login", data, function(data){
			data = jQuery.parseJSON(data);
			if (data.result){
				window.location.href = "/owners";
			}
		});
		return false;
	});
});