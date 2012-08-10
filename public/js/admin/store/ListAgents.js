Ext.define("Leadschat.store.ListAgents", {
	extend:"Ext.data.Store",
	model:"Leadschat.model.Agent",
	proxy: {
         type: 'ajax',
         url: '/agents/list-all',
         reader: {
             type: 'json',
             root: 'dataLoaded',
             totalProperty:"total"
         }
    },
    storeId:"agentsListStore",
    autoLoad: true
});