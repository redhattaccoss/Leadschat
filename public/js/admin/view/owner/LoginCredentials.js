Ext.define("Leadschat.view.owner.LoginCredentials", {
	extend:"Ext.form.Panel",
	alias:"widget.owner_logincredentials",
	border:false,
	defaults:{
		xtype:"fieldset"
	},
	bodyPadding:5, 
	initComponent:function(){
		this.items = [
               {
			    	html:"<h1 class='owner_information_header'>Generate Password</h1>",
			    	name:"header_login_info_owner",
			    	xtype:"panel",
			    	border:false
			    },
		        {
		        	title:"Generate new password",
		        	defaults:{
   			    		xtype:"textfield",
   			    		width:400,
   			    		inputType:"password",
   			    		maxLength:30,
   			    		minLength:3
   			       	},
		        	items:[
			              {
			            	fieldLabel:"New Password",
			            	name:"new_password"
			              },
			              {
			            	fieldLabel:"Confirm Password",
			                name:"confirm_password"
			              }
		        	]
		        },
		        
		        
		        {xtype:"button", text:"Generate"}
		]
		this.callParent(arguments);
	}
})