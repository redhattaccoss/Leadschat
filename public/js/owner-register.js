jQuery(document).ready(function() {

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

	jQuery("#timezone_id option").each(function() {
		var id = jQuery(this).val();
		var me = jQuery(this);
		jQuery.each(timezones, function(i, item) {
			if (item.timezone_id == id) {
				me.addClass(item.flag_icon);
				return false;
			}
		})
	});

	function clearSuccess() {
		jQuery(".error").each(function() {
			if (jQuery(this).hasClass("success") && jQuery(this).text() != "") {
				jQuery(this).removeClass("success");
			}
		});
	}

	setInterval(clearSuccess, 100);

	jQuery("#number_of_hit_id").selectmenu({
		height : 100,
		width : 280
	});

	jQuery("#timezone_id").selectmenu({
		height : 100,
		width : 280,
		icons : [ {
			find : ".america",
			icon : "ui-icon-america"
		}, {
			find : ".australia",
			icon : "ui-icon-australia"
		}, {
			find : ".canada",
			icon : "ui-icon-canada"
		}, {
			find : ".uk",
			icon : "ui-icon-uk"
		}, {
			find : ".scotland",
			icon : "ui-icon-scotland"
		}, {
			find : ".ireland",
			icon : "ui-icon-ireland"
		}, {
			find : ".wales",
			icon : "ui-icon-wales"
		},

		]

	});

	jQuery("#registration-form").validate({
		errorElement : "em",
		errorPlacement : function(error, element) {
			error.appendTo(element.parent("dd")).removeClass("success");
		},
		success : function(label) {
			label.addClass("success");
		},
		rules : {
			first_name : {
				required : true,
				minlength : 2
			},
			last_name : {
				required : true,
				minlength : 2
			},
			password : {
				required : true,
				minlength : 6
			},
			confirm_password : {
				required : true,
				minlength : 6,
				equalTo : "#password"
			},
			email : {
				required : true,
				email : true,
				uniqueEmail : true,
			},
			username : {
				required : true,
				minlength : 6,
				uniqueUserName : true
			},
			business_type : {
				required : true
			},
			timezone_id : {
				required : true
			},
			number_hits : {
				required : true
			},
			website : {
				required : true,
				minlength : 10
			},
			mobile:{
				required:true,
				minlength:10
			}

		}
	});
	jQuery("#registration-form").submit(function() {
		if (jQuery(this).valid()) {
			var data = jQuery(this).serialize();
			jQuery.post("/owners/process-register", data, function(result) {
				console.log(result);
				result = jQuery.parseJSON(result);
				if (result.result) {
					window.location.href = "/owners/register-complete"
				}
			})
		}
		return false;
	});
});