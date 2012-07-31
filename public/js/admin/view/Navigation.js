Ext.define("Leadschat.view.Navigation", {
	extend:"Ext.tree.Panel",
	alias:"widget.navigation",
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
                   },
                   {
                	   text:"Manage Owners",
                	   leaf:true
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
            	text:"Visitors and Chats",
            	expanded:true,
            	children: [
                   {
                       text: 'Manage Visitors',
                       leaf: true
                   },
                   {
                       text: 'Manage Chats',
                       leaf: true
                   }
                ]
            },
            {
            	text: "Administration",
            	expanded:true,
            	children:[
            	     {
            	    	 text: 'Call Center',
            	    	 expanded:true,
            	    	 children:[
            	    	           {
            	    	        	  text:"Manage Call Centers",
            	    	        	  leaf:true
            	    	           },
            	    	           {
            	    	        	   text:"Add New Call Center",
            	    	        	   leaf:true   
            	    	           },
            	    	 ]
            	     },
            	     {
            	    	 text: 'Agents',
            	    	 expanded:true,
            	    	 children:[
            	    	           {
            	    	        	  text:"Manage Agents",
            	    	        	  leaf:true
            	    	           },
            	    	           {
            	    	        	   text:"Register an Agent",
            	    	        	   leaf:true   
            	    	           },
            	    	 ]
            	     },
            	     {
            	    	text:"Schedules",
            	    	expanded:true,
           	    	 	children:[
           	    	 	          {
           	    	 	        	text:"Manage Schedules",
           	    	 	        	leaf:true
           	    	 	          }
           	    	 	]
            	     },
            	     {
            	    	 text:"Invoices",
            	    	 children:[
            	    	           {
            	    	        	   text:"Manage Invoices",
            	    	        	   leaf:true
            	    	           }
            	    	 ]
            	     }
            	          
            	]
            },
            {
            	text:"Settings",
            	expanded:true
            },
            {
            	text:"Logout",
            	leaf:true
            }
        ]
    }
});
