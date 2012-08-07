Ext.define("Leadschat.view.owner.BasicInformation", {
	extend:"Ext.form.Panel",
	alias:"widget.owner_basicinformation",
	border:false,
	defaults:{
		xtype:"fieldset"
	},
	layout:"column",
	setLabel:function(record){
		var component = Ext.ComponentQuery.query("panel[name=header_basic_info_owner]");
		component = component[0];
		component.html = "<h1 class='owner_information_header'> Lead # "+record.get("owner_id")+"</h1>";
	},
	initComponent:function(){
		this.items = [
			    {
			    	columnWidth:1,
			    	html:"<h1 class='owner_information_header'> Lead # </h1>",
			    	name:"header_basic_info_owner",
			    	xtype:"panel",
			    	border:false
			    },
			    {
			    	xtype:"fieldset",
			    	title:"Contact Information",
			    	defaults:{
			    		xtype:"textfield",
			    		width:400
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
							name:"email",
							fieldLabel:"Email Address"
						},
						{
							name:"mobile",
							fieldLabel:"Mobile Number"
						},
						{
							name:"username",
							fieldLabel:"Username"
						},
						{
							name:"owner_type",
							fieldLabel:"Owner Type",
							xtype:"combobox",
							store:"OwnerTypes",
							valueField:"value",
							tpl: Ext.create('Ext.XTemplate',
							        '<tpl for=".">',
							            '<div class="x-boundlist-item">{label}</div>',
							        '</tpl>'
							),
							displayTpl: Ext.create('Ext.XTemplate',
							        '<tpl for=".">',
							            '{label}',
							        '</tpl>'
							)
						},
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
						}
						 
						
			    	]
			    },
			    {
			    	width:30,
			    	border:false
			    },
			    {
			    	xtype:"fieldset",
			    	title:"Business Information",
			    	defaults:{
			    		xtype:"textfield",
			    		width:400
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
							fieldLabel:"Operational Timezone",
							xtype:"combobox",
							store:"Timezones",
							valueField:"timezone_id",
							tpl: Ext.create('Ext.XTemplate',
							        '<tpl for=".">',
							            '<div class="x-boundlist-item">{name}</div>',
							        '</tpl>'
							),
							displayTpl: Ext.create('Ext.XTemplate',
							        '<tpl for=".">',
							            '{name}',
							        '</tpl>'
							)
						},
						{
							name:"number_of_hit_id",
							fieldLabel:"Number of Hits per day",
							xtype:"combobox",
							store:"NumberOfHits",
							valueField:"id",
							tpl: Ext.create('Ext.XTemplate',
							        '<tpl for=".">',
							            '<div class="x-boundlist-item">{name}</div>',
							        '</tpl>'
							),
							displayTpl: Ext.create('Ext.XTemplate',
							        '<tpl for=".">',
							            '{name}',
							        '</tpl>'
							)
						},
						{
							name:"fullname_webmaster",
							fieldLabel:"Web Master Fullname"
						},
						{
							name:"email_webmaster",
							fieldLabel:"Web Master Email"
						},
						{
							name:"phone_webmaster",
							fieldLabel:"Web Master Home"
						}
			    	]
			    }
			    
			    
			]
		this.callParent(arguments);
	}
	


})