Ext.define("Leadschat.model.Timezone", {
	extend:"Ext.data.Model",
	fields:[
	        {name:'timezone_id', type:'int'},
	        {name:'name', type:'string'},
	        {name:'timezone_group_id', type:'int'},
	        {name:'operational', type:'string'},
	        {name:'flag_icon', type:'string'}
	],
	associations:[
	  {type:"hasOne", model:"TimezoneGroup", name:"timezone_group"}            
	]

})