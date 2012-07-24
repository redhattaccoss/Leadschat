var LeadschatRegistry = {
	baseUrl:"",
	getUrl:function(controller, action){
		return this.baseUrl+"/"+controller+"/"+action;
	},
	bootstrapData:null,
	currentPage:"Home"
};


var LeadschatNamespace = {};
LeadschatNamespace.controller = {};
LeadschatNamespace.controller.OWNERS = "owners";

LeadschatNamespace.action = {}
LeadschatNamespace.action.BOOTSTRAP_DASHBOARD = "bootstrap-dashboard";

