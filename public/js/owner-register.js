jQuery(document).ready(function(){
	jQuery("select").selectmenu();
	
	jQuery("#registration-form").submit(function(){
		var data = jQuery(this).serialize();
		jQuery.post("/owners/process-register", data, function(result){
			result = jQuery.parseJSON(result);
			if (result.success){
				window.location.href = "/owners/register-success"
			}
		})
		return false;
	});
});