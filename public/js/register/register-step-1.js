jQuery(document).ready(function(){
	//bootstrap validator
	jQuery.validator.addMethod("uniqueUserName", function(value, element) {
		var result = false;
		jQuery.ajax({
			type : "GET",
			url : "/owners/username-existing",
			data : "username=" + value,
			dataType : "html",
			async : false,
			success : function(msg) {
				msg = jQuery.parseJSON(msg);
				msg = msg.success;
				// if the user exists, it returns a string "true"
				result = !msg.success; // username is free to use
			}

		});
		return result;
	}, "Username is Already Taken");

	jQuery.validator.addMethod("uniqueEmail", function(value, element) {
		var result = false;
		jQuery.ajax({
			type : "GET",
			url : "/owners/email-existing",
			data : "email=" + value,
			dataType : "html",
			async : false,
			success : function(msg) {
				// if the user exists, it returns a string "true"
				msg = jQuery.parseJSON(msg);
				result = !msg.success;
			}
		});
		return result;
	}, "Email is Already Taken");
	
	
	function updateStatus(){
		jQuery("input[type=text]").each(function(){
			if (jQuery(this).hasClass("error")){
				jQuery(this).parent().parent().removeClass("success").addClass("error");
			}else if (jQuery(this).hasClass("success")){
				jQuery(this).parent().parent().removeClass("error").addClass("success");
			}
		})
	}
	
	setInterval(updateStatus, 1);
	
	jQuery("#registration-form-1").validate({
		errorElement : "span",
		errorPlacement : function(error, element) {
			error.addClass("help-inline").appendTo(element.parent(".controls")).parent().parent().removeClass("error").removeClass("success").addClass("error");			
		},
		success : function(label) {
			label.parent().parent().removeClass("error").removeClass("success").addClass("success");
		},
		rules:{
			first_name : {
				required : true,
				minlength : 2
			},
			last_name : {
				required : true,
				minlength : 2
			},
			email : {
				required : true,
				email : true,
				uniqueEmail : true,
			},
			confirm_email : {
				required : true,
				email : true,
				equalTo : "#email"
			},
			
		}
	});
	
	
	
});