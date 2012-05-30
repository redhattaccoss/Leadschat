var leadschat = {timer:-1, visitor_i:-1};
leadschat.visitor_id = -1;
leadschat.timer = {};
leadschat.timer.getaccept = -1;
leadschat.timer.getacceptattempt = 0;

$(document).ready(function(){
	leadschat.visitor_id = jQuery("#from_id").val();
	leadschat.website = jQuery("#website").val();
	function initialize(){
		jQuery.get("/chats/get-visitor-session", function(session){
			session = jQuery.parseJSON(session);
			if (session.success){
				jQuery("#from_id").val(session.visitor_id);
				jQuery("#chat_session_id").val(session.chat_session.chat_session_id);
				leadschat.selectedChatSessionId = session.chat_session.chat_session_id;
				leadschat.timer.loadChat = setInterval(loadChats, 10000);
				jQuery.get("/chats/get-session-info?chat_session_id="+leadschat.selectedChatSessionId, function(data){
					data = jQuery.parseJSON(data);
					if (data.success){
						jQuery("#agent-name").text(data.agent.first_name+" "+data.agent.last_name);
						if (data.agent.picture!=null){
							jQuery("#agent-picture.container").html("<img src='/public"+data.agent.picture+"' alt='"+data.agent.first_name+"'/>");
						}
					}
				});
			}else{
				jQuery.get("/chats/initialize?website="+leadschat.website+"&visitor_id="+leadschat.visitor_id, function(data){
					data = jQuery.parseJSON(data);
					
					if (data.success){
						getAcceptRequest();
						leadschat.timer.getaccept = setInterval(getAcceptRequest, 10000);
					}
				});	
			}
		});

	}
	
	function scrollMessage(){
		var totalMessageHeight = 0;
		jQuery(".chat-item").each(function(){
			totalMessageHeight += jQuery(this).outerHeight(true);
		})
		console.log(totalMessageHeight);
		jQuery("#chat-list").scrollTop(totalMessageHeight);
	}
	
	
	function renderChats(data){
		leadschat.selectedChatSessionChat = data.chats;	
		var output = "";
		jQuery.each(data.chats, function(i, item){
			var _class = "";
			var name = "";
			
			if (item.from_type=="A"){
				_class = "name agent-name";
				name = data.agent.first_name+" "+data.agent.last_name;
			}else{
				_class = "name";
				name = "You";
			}
			var message = "<div class=\"chat-item\"><div class=\"content\">";
			message+="<div class=\""+_class+"\">"+name+"</div>";	
			message+=("<p>"+item.message+"</p></div>");		
			message+="<div class=\"time\">";		
			message+=(item.formatted_time+"</div></div>");
			output+=message;
		});
		jQuery("#chat-list").html(output);
		scrollMessage();
	}
	
	function loadChats(){
		if (leadschat.selectedChatSessionId!=-1){
			jQuery.post("/chats/load-chat", {chat_session_id:leadschat.selectedChatSessionId}, function(data){
				data = jQuery.parseJSON(data);
				var output = "";
				//console.log(data.chats);
				if (leadschat.selectedChatSessionChat==null){
					renderChats(data);
				}else{
					if (leadschat.selectedChatSessionChat.length!=data.chats.length){
						renderChats(data);
					}
				}
				
			});		
		}
	}
	
	function getAcceptRequest(){
		jQuery.post("/chats/get-accepted-request", {visitor_id:leadschat.visitor_id}, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				clearInterval(leadschat.timer.getaccept);
				leadschat.timer.getacceptattempt = 0;
				jQuery("#chat_session_id").val(data.chat_session.chat_session_id);
				leadschat.selectedChatSessionId = data.chat_session.chat_session_id;
				leadschat.timer.loadChat = setInterval(loadChats, 10000);
				jQuery.get("/chats/get-session-info?chat_session_id="+leadschat.selectedChatSessionId, function(data){
					data = jQuery.parseJSON(data);
					if (data.success){
						jQuery("#agent-name").text(data.agent.first_name+" "+data.agent.last_name);
						if (data.agent.picture!=null){
							jQuery("#agent-picture.container").html("<img src='/public"+data.agent.picture+"' alt='"+data.agent.first_name+"'/>");
						}
					}
				});
			}else{
				if (leadschat.timer.getacceptattempt==20){
					clearInterval(leadschat.timer.getaccept);
					leadschat.timer.getacceptattempt = 0;							
					initialize();
				}else{
					leadschat.timer.getacceptattempt++;			
				}
			}
		});
	}
	function sendMessage(){
		if (jQuery.trim(jQuery("#message-text").val())!=""){
			if(leadschat.selectedChatSessionId!=-1){
				var data = jQuery("#chat-form").serialize();
				jQuery("#message-text").attr("disabled", "disabled");
				jQuery.post("/chats/send", data, function(data){
					data = jQuery.parseJSON(data);
					if (data.success){
						renderChats(data);
					}
					jQuery("#message-text").removeAttr("disabled").val("").text("").focus();
				});
			}else{
				alert("Please select a chat request to chat with");
			}	
		}else{
			alert("Please enter a message to send");
			jQuery("#message-text").removeAttr("disabled").val("").text("").focus();
		}
	}
	
	jQuery("#send-chat").click(function(e){
		sendMessage();
		e.preventDefault();
	});
	
	jQuery("#message-text").keydown(function(e){
		if (!e.shiftKey){
			if (e.keyCode==13){
				sendMessage();
				e.preventDefault();
			}
		}
	});
	
	initialize();

});