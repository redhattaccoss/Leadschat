Ext.define("Leadschat.model.Agent", {
	extend:"Ext.data.Model",
	fields:[
	        {name:"agent_id", type:"int"},
	        {name:"first_name", type:"string"},
	        {name:"last_name", type:"string"},
	        {name:"username", type:"string"},
	        {name:"password", type:"string"},
	        {name:"type", type:"string"},
	        {name:"call_center", type:"auto"},
	        {name:"active",type:"string"}	        
	]
})