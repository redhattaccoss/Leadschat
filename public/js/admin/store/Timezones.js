Ext.define("Leadschat.store.Timezones", {
	extend:"Ext.data.Store",
	model:"Leadschat.model.Timezone",
	require:"Leadschat.model.Timezone",
	proxy: {
         type: 'ajax',
         url: '/timezones/list',
         reader: {
             type: 'json',
             root: 'dataLoaded'
         }
    },
    storeId:"timezonesListStore",
    autoLoad: true
});