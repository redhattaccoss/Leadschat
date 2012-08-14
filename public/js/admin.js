Ext.Loader.setConfig({
    enabled: true
});
Ext.Loader.setPath('Ext.ux', '../examples/ux');

Ext.application({
	name:"Leadschat",
	appFolder:"../public/js/admin",
	autoCreateViewport: true,
	controllers:[
	             "Owners", "Main", "Accounts", "Agents", "CallCenters"
	],
	launch:function(){
		
	}
})
