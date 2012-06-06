Ext.Loader.setConfig({
    enabled: true
});
Ext.Loader.setPath('Ext.ux', '../examples/ux');

Ext.application({
	name:"Leadschat",
	appFolder:"../public/js/app",
	autoCreateViewport: true,
	controllers:[
	             "Owners", "Main"
	],
	launch:function(){
		
	}
})
