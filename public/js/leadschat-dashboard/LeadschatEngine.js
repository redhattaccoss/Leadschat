var LeadschatEngine = function(){
	this.bootstrapData = null;
	this.templates = {};
}
LeadschatEngine.prototype.boot = function(){
	this.__renderBaseDashboard();
	this.__loadTemplates();
	this.__events();
	var ns = LeadschatNamespace;
	var me = this;
	jQuery.get(LeadschatRegistry.getUrl(ns.controller.OWNERS, ns.action.BOOTSTRAP_DASHBOARD), function(data){
		me.bootstrapData = jQuery.parseJSON(data);
		LeadschatRegistry.bootstrapData = me.bootstrapData;
		me.__loadPage();
	});
}

LeadschatEngine.prototype.__loadTemplates = function(){
	this.templates.home = new HomeView();
	Interface.ensureImplements(this.templates.home, LeadschatView);
}

LeadschatEngine.prototype.__events = function(){
	
}

LeadschatEngine.prototype.__renderBaseDashboard = function(){
	/**
	 * Callback for resize Event
	 */
	function resizeDashboard(){
		if (jQuery(this).width()<=1400){	
			jQuery("#trial-advisory-header").fadeOut(100);
			jQuery("#trial-advisory-side").show();
		}else{
			jQuery("#trial-advisory-header").show();
			jQuery("#trial-advisory-side").hide();
		}
		var bodyHeight = jQuery("body").height()-jQuery("header").height()-jQuery("footer").height()-5;
		var bodyWidth = jQuery("body").width()-jQuery("#navigation-main-right").outerWidth()-jQuery("#navigation-main").outerWidth();
		jQuery("#navigation-main").height(jQuery("body").height()-jQuery("header").height()-jQuery("footer").height()-5);

		jQuery("#main-content-container").height(bodyHeight);
		if (jQuery("body").width()>=980){
			if (jQuery.browser.webkit){
				jQuery("#main-content-container").width(bodyWidth);	
			}else{
				jQuery("#main-content-container").width(bodyWidth-10);
			}
		}
		jQuery("#main-content-container-body").height(bodyHeight-86);
		jQuery("#navigation-main-right").height(bodyHeight);
		jQuery("#chat-area").height(bodyHeight-jQuery("#contact-info").outerHeight(true)-51);
		
	
	}
 	jQuery("#main-content-container-body").mCustomScrollbar();
 	jQuery("#chat-area").mCustomScrollbar();
 	jQuery("#navigation-main").mCustomScrollbar();
	jQuery(window).resize(resizeDashboard);
	setInterval(resizeDashboard, 1);
}

LeadschatEngine.prototype.__loadPage = function(){
	jQuery("#main-content-container-body").html(this.templates.home.toString())
}

