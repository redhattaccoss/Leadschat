jQuery(document).ready(function(){
	
	//bootstrap validator
	jQuery.validator.addMethod("uniqueUserName", function(value, element) {
	  jQuery.ajax({
	      type: "POST",
	       url: "php/get_save_status.php",
	      data: "checkUsername="+value,
	      dataType:"html",
	   success: function(msg)
	   {
	      // if the user exists, it returns a string "true"
	      if(msg == "true")
	         return false;  // already exists
	      return true;      // username is free to use
	   }
	 })}, "Username is Already Taken");
	
	
	jQuery("select").selectmenu({
		height:100,
		width:280
	});
	
	jQuery("#registration-form").validate({
		errorElement: "em",
		errorPlacement: function(error, element) {
			error.appendTo( element.parent("dd") );
		},
		success: function(label) {
			label.addClass("success");
		},
		rules:{
			first_name:{
				required:true,
				minlength:2
			},
			last_name:{
				required:true,
				minlength:2
			},
			password:{
				required:true,
				minlength:6
			},
			confirm_password:{
				required:true,
				minlength:6,
				equalTo:"#password"
			},
			email:{
				required:true,
				email:true
			},
			username:{
				required:true,
				minlength:6
			},
			business_type:{
				required:true
			},
			timezone_id:{
				required:true
			},
			number_hits:{
				required:true
			},
			website:{
				required:true,
				minlength:10
			}
			
			
			
		}
	});
	jQuery("#registration-form").submit(function(){
		if (jQuery(this).valid()){
			var data = jQuery(this).serialize();
			jQuery.post("/owners/process-register", data, function(result){
				result = jQuery.parseJSON(result);
				if (result.success){
					window.location.href = "/owners/register-success"
				}
			})	
		}
		return false;
	});
});