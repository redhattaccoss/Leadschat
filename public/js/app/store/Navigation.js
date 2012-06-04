Ext.define("Leadschat.store.Navigation", {
	extend:"Ext.data.TreeStore",
	root: {
        text: 'Navigation',
        expanded: true,
        children: [
            {
                text: 'Owners',
                expanded:true,
                children: [
                   {
                       text: 'Newly Registered',
                       leaf: true
                   }
                ]
            },
            {
                text: 'Leads',
                expanded:true,
                children: [
                   {
                       text: 'To be approved leads',
                       leaf: true
                   },
                   {
                       text: 'Approved leads',
                       leaf: true
                   },
                   {
                       text: 'Expired leads',
                       leaf: true
                   }
                ]
            },
            {
            	text:"Logout",
            	leaf:true
            }
        ]
    }
})