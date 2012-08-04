Ext.define("Leadschat.store.Owners", {
	extend:"Ext.data.Store",
	model:"Leadschat.model.Owner",
	require:"Leadschat.model.Owner",
	proxy: {
         type: 'ajax',
         url: '/owners/process-list',
         reader: {
             type: 'json',
             root: 'dataLoaded',
             totalProperty:"total"
         }
    },
    storeId:"ownersListStore",
    autoLoad: true
});
