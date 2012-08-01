Ext.Loader.setConfig({
    enabled: true
});
Ext.Loader.setPath('Ext.ux', '../examples/ux');

Ext.application({
	name:"LeadschatQA",
	appFolder:"../public/js/qa",
	autoCreateViewport: true,
	controllers:[
	             "Main"
	],
	launch:function(){
		
	}
})
