Ext.define("Leadschat.view.owner.BasicInformation", {
	extend:"Ext.form.Panel",
	alias:"widget.owner_basicinformation",
	border:false,
	defaults:{
		xtype:"fieldset"
	},
	layout:"column",
	items:[
	    {
	    	xtype:"fieldset",
	    	title:"Contact Information",
	    	defaults:{
	    		xtype:"textfield"
	    	},
	    	columnWidth:0.5,
	    	items:[
	   
	    		{
					name:"first_name",
					fieldLabel:"First Name"
				},
				{
					name:"last_name",
					fieldLabel:"Last Name"
				},
				{
					name:"email_address",
					fieldLabel:"Email Address"
				}
				
	    	]
	    },
	    {
	    	xtype:"fieldset",
	    	title:"Business Information",
	    	defaults:{
	    		xtype:"textfield"
	    	},
	    	columnWidth:0.5,
	    	items:[
	    	    {
	    	    	name:"company",
	    	    	fieldLabel:"Company"
	    	    },
	    	    {
	    	    	name:"company_contact",
	    	    	fieldLabel:"Contact Number"
	    	    },
				{
					name:"business_type",
					fieldLabel:"Business Type"
				},
				{
					name:"timezone_id",
					fieldLabel:"Operational Timezone"
				},
				{
					name:"number_of_hit_id",
					fieldLabel:"Number of Hits per day"
				}

	    	]
	    },
	    {
	    	xtype:"fieldset",
	    	title:"Business Address",
	    	defaults:{
	    		xtype:"textfield"
	    	},
	    	columnWidth:0.5,
	    	items:[
				{
					name:"address1",
					fieldLabel:"Address 1"
				},
				{
					name:"address2",
					fieldLabel:"Address 2"
				},
				{
					name:"city",
					fieldLabel:"City"
				},
				{
					name:"state",
					fieldLabel:"State [For US Only]"
				},
				{
					name:"postal",
					fieldLabel:"Postal"
				},
				{
					name:"country",
					fieldLabel:"Country"
				},
				

	    	]
	    }
	    
	    
	]


})