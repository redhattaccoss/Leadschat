jQuery(document).ready(function(){
	jQuery("#login-form").submit(function(){
		var formData = jQuery(this).serialize();
		jQuery.post("/agents/process-login", formData, function(data){
			data = jQuery.parseJSON(data);
			if (data.result){
				window.location.href = "/agents/dashboard";
			}else{
				alert(data.message);
			}
		})
		return false;
	});
});