Ext.define("Leadschat.store.NumberOfHits", {
	extend:"Ext.data.Store",
	model:"Leadschat.model.NumberOfHit",
	require:"Leadschat.model.NumberOfHit",
	proxy: {
         type: 'ajax',
         url: '/number-of-hits/list',
         reader: {
             type: 'json',
             root: 'dataLoaded'
         }
    },
    storeId:"numberofhitsListStore",
    autoLoad: true
});