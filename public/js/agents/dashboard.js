var leadschat = {};
leadschat.chatSessions = [];
leadschat.timer = {};
leadschat.request = {};
leadschat.request.chat_request = false;
leadschat.request.chat_session = false;
leadschat.selectedChatSessionId = -1;
leadschat.selectedChatSessionChat = null;
leadschat.savingMode = false;
jQuery(document).ready(function(){	
	
	function resizeChatBoard(source){
		var windowHeight = jQuery(source).height();
		var header = jQuery("header").height();
		jQuery("#chat-list").height(windowHeight-header);
		jQuery("#chat-area").height(windowHeight-header);
		jQuery("#leads-info").height(windowHeight-header);
		
	}
	
	function loadDashboard(){
		resizeChatBoard(window);
		jQuery(window).resize(function(){
			resizeChatBoard(window)
		});
		
	}
	
	function renderSessionList(){
		var output = "";
		jQuery.each(leadschat.chatSessions, function(i, item){
			output+="<li class='chat-session-item' data-chat-session='"+item.chat_session.chat_session_id+"'>";
			output+=("<span class='ip'>"+item.visitor.ip+"</span>&nbsp;");
			output+=("<span class='website'>("+item.owner.website+")</span>");
			if (parseInt(item.unread_messages)>0){
				output+=("&nbsp;<span class='unread'>"+item.unread_messages+"</span>");	
			}
			output+="</li>";
		});
		jQuery("#chat-list ul").html(output);
	}
	
	function loadChatRequests(){
		//we load chat requests
		if (!leadschat.request.chat_request){
			leadschat.request.chat_request = true;
			jQuery.get("/agents/load-chat-requests", function(data){
				leadschat.request.chat_request = false;
				data = jQuery.parseJSON(data);
				if (data.result&&data.rows!=null){
					jQuery.each(data.rows, function(i, item){
						jQuery.post("/agents/accept-request", {requestId:item.chat_request_id}, function(acceptRequest){
							acceptRequest = jQuery.parseJSON(acceptRequest);
							/*
							if (acceptRequest.result){
								leadschat.chatSessions.chat_sessions.push(acceptRequest.chat_session_id);
							}
							if (leadschat.chatSessions.chat_sessions.length>4){
								clearInterval(leadschat.timer.chat_requests); 
							}
							*/
						})
					});
				}
			});	
		}
	}
	
	function scrollMessage(){
		var totalMessageHeight = 0;
		jQuery(".chat-message").each(function(){
			totalMessageHeight += jQuery(this).height();
		})
		jQuery("#chat-area-text").scrollTop(totalMessageHeight);
	}
	
	function renderChat(data){
		leadschat.selectedChatSessionChat = data.chats;	
		jQuery.each(data.chats, function(i, item){
			var _class = "";
			var name = "";
			if (item.from_type=="A"){
				_class = "agent-chat-message";
				name = "You";
			}else{
				_class = "visitor-chat-message";
				name = "Visitor";
			}
			output+="<div class='chat-message'>";
			output+=("<span class='sender "+_class+"'>"+name+"</span>");
			output+=("<span class='message'>"+item.message+"</span>");
			output+=("<span class='time'>"+item.formatted_time+"</span>");
			output+="</div>";
		});
		jQuery("#chat-area-text").html(output);
		scrollMessage();
	}
	
	function loadChats(){
		if (leadschat.selectedChatSessionId!=-1){
			jQuery.post("/chats/load-chat", {chat_session_id:leadschat.selectedChatSessionId}, function(data){
				data = jQuery.parseJSON(data);
				var output = "";
				//console.log(data.chats);
				if (leadschat.selectedChatSessionChat==null){
					renderChat(data);
				}else{
					if (leadschat.selectedChatSessionChat.length!=data.chats.length){
						renderChat(data);
					}
				}
				
			});	
		}
	}
	
	
	function loadSession(){
		//we load session
		if (!leadschat.request.chat_session){
			leadschat.request.chat_session = true;
			jQuery.get("/agents/load-session", function(data){
				leadschat.request.chat_session = false;
				data = jQuery.parseJSON(data);
				if (checkSessionIfNew(data.chat_sessions)){
					leadschat.chatSessions = data.chat_sessions;
					renderSessionList();			
				}
			});	
		}
	}
	
	function checkSessionIfNew(loadedchat_sessions){
		if (leadschat.chatSessions.length!=loadedchat_sessions.length){
			return true;
		}
		for(var i=0;i<leadschat.chatSessions.length;i++){
			var session = leadschat.chatSessions[i];
			if (session.chat_session.chat_session_id!=loadedchat_sessions[i].chat_session.chat_session_id){
				return true;
			}
			if (session.chat_session.unread_messages!=loadedchat_sessions[i].chat_session.unread_messages){
				return true;
			}
		}
		return false;
	}
	loadDashboard();
	
	//we load session
	jQuery.get("/agents/load-session", function(data){
		data = jQuery.parseJSON(data);
		leadschat.chatSessions = data.chat_sessions;
		renderSessionList();
		loadChatRequests();
		leadschat.timer.chat_requests = setInterval(loadChatRequests, 10000);
		leadschat.timer.dashboard = setInterval(loadDashboard, 100);
		leadschat.timer.chat_sessions = setInterval(loadSession, 10000);
		leadschat.timer.load_chats = setInterval(loadChats, 10000);
	});
	
	
	
	
	//events
	jQuery(".chat-session-item").live("click", function(){
		jQuery(".chat-session-item").removeClass("chat-session-item-selected");
		jQuery(this).addClass("chat-session-item-selected");
		var sessionId = jQuery(this).attr("data-chat-session");
		jQuery.post("/agents/view-session", {chat_session_id:sessionId}, function(data){
			data = jQuery.parseJSON(data);
			jQuery("#owner_full_name").text(data.owner.first_name+" "+data.owner.last_name);
			if (data.owner.company!=null){
				jQuery("#owner_company").text(data.owner.company);	
			}else{
				jQuery("#owner_company").text("");
			}
			
			jQuery("#owner_website").text(data.owner.website);
			
			if (data.owner.owner_type!=null){
				jQuery("#owner_type").text(data.owner.owner_type);
			}else{
				jQuery("#owner_type").text("");
			}
			leadschat.selectedChatSessionId = data.chat_session.chat_session_id;
			jQuery("#chat_session_id").val(leadschat.selectedChatSessionId);
			jQuery("#message-text").focus();
		});
	});
	
	function sendMessage(){
		if (jQuery.trim(jQuery("#message-text").val())!=""){
			if(leadschat.selectedChatSessionId!=-1){
				var data = jQuery("#chat-form").serialize();
				jQuery("#message-text").attr("disabled", "disabled");
				jQuery.post("/chats/send", data, function(data){
					data = jQuery.parseJSON(data);
					if (data.success){
						renderChat(data);	
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
	
	jQuery("#save-button").click(function(e){
		
		e.preventDefault();
	});
	
	jQuery("#end-chat-button").click(function(e){
		if (!leadschat.savingMode){
			var confirmClose = confirm("Are you sure you want to end the chat now?");
			if (confirmClose){
				jQuery.post("/agents/end-chat", {chat_session_id:leadschat.selectedChatSessionId}, function(data){
					data = jQuery.parseJSON(data);
					alert("Chat has been ended successfully.\nPlease kindly review the leads information and click save when you are done.\nThank you")
					leadschat.savingMode = true;
				});	
			}	
		}
		e.preventDefault();
	});
	
	
});