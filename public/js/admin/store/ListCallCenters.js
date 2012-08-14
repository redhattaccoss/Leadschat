Ext.define("Leadschat.store.ListCallCenters", {
	extend:"Ext.data.Store",
	model:"Leadschat.model.CallCenter",
	proxy: {
        type: 'ajax',
        url: '/call-center/list',
        reader: {
            type: 'json',
            root: 'dataLoaded',
            totalProperty:"total"
        }
   },
   storeId:"callcenterListStore",
   autoLoad: true
});