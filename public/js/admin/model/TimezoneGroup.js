Ext.define("Leadschat.model.TimezoneGroup", {
	extend:"Ext.data.Model",
	fields:[
	        {name:"timezone_group_id", type:"int"},
	        {name:"name", type:"string"}
	],
	associations:[
	              {type:"hasMany", model:"Timezone", name:"timezones"}
	]
})