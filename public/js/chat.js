let Chat = {
	
	currentChannel: null,
	
	countNewMessages: {
		'general' : 0,
	},

	changeStructuralUnit: function(selector, Pusher, authId){
        if(selector && Pusher && authId){
			let thisMain = this;
			
			thisMain.unsubscribeChannel(Pusher);
			
			if(selector.val()) {
				$('#chat_users').val(null).trigger('change');
				
				thisMain.listenStructuralUnitChannel(Pusher, authId, selector.val());
				
				thisMain.selectChannel(authId, 'structural_units', selector.val(), selector.find('option:selected').text());
				
			} else {
				if(!$('#chat_users').val()) {
					thisMain.listenGeneralChannel(Pusher, authId);
				}
			}
			
            return true;
        }
        return false;
    },
	
	changeUser: function(selector, Pusher, authId){
        if(selector && Pusher && authId){
			let thisMain = this;
			
			thisMain.unsubscribeChannel(Pusher);
			
			if(selector.val()) {
				$('#chat_structural_units').val(null).trigger('change');
				
				thisMain.listenUserChannel(Pusher, authId, selector.val());
				
				thisMain.selectChannel(authId, 'users', selector.val(), selector.find('option:selected').text());
			} else {
				if(!$('#chat_structural_units').val()) {
					
					thisMain.listenGeneralChannel(Pusher, authId);
				}
			}
			
            return true;
        }
        return false;
    },
	
	renameChat: function(name) {
		
		if(!name) {
			name = 'Чат';
		}
		
		$('#chat_widget').find('.card-title').text(name);
	},
	
	selectedChannelAuthUser: function(Pusher, data, authId) {
		if(data) {
			$('#chat_' + data['type']).val(data['id']).trigger('change');
		} else {
			return this.listenGeneralChannel(Pusher, authId);
		}
	},
	
	selectChannel: function(authId, type, id, nameChannel, nextPage){
		let thisMain = this,
			selectorCard = $('#chat_widget').find('.card');
		
		let errorHandle = function(jqXHR, textStatus, errorThrown ){
			let data = jqXHR.responseJSON;

			Main.popUp('Произошла ошибка при подгрузке сообщений чата');

			selectorCard.find('.overlay').remove();
		};

		let successEvent = function(arrayData){
			if(arrayData['status'] && arrayData['status'] == 'success'){
				
				let htmlMessages = '';
				
				if(arrayData['messages']['data']) {
					$.each(arrayData['messages']['data'], function( key, value ) {
						htmlMessages += thisMain.chatCollectMessage(value, authId);
					});
				}
				
				if(arrayData['messages']['count_new_messages']) {
					let countMsg = 0;
					
					thisMain.noteNewMesages(arrayData['messages']['count_new_messages'], selectorCard, countMsg);
					
				}
				
				if(nextPage) {
					let dataDCM = selectorCard.find('.direct-chat-messages')[0];
					let startHeight = dataDCM['scrollHeight'];
					
					selectorCard.find('.direct-chat-messages').prepend(htmlMessages);
					
					dataDCM.scrollTop = (dataDCM['scrollHeight'] - startHeight) - 30;
					
				} else {
					selectorCard.find('.direct-chat-messages').html(htmlMessages);
				}
				
				if(arrayData['messages']['pagination']) {
					selectorCard.find('.direct-chat-messages').prepend('<button type="button" class="btn btn-block btn-success btn-sm mb-2" onclick="Chat.selectChannel(' + authId + ', \'' + type + '\', \'' + id + '\', \'' + ((nameChannel) ? nameChannel : '') + '\', ' + arrayData['messages']['pagination'] + ');$(this).remove();" >Загрузить еще...</button>');
				} 
				
				if(!nextPage) {
					thisMain.scrolDirectMessagesBottom(selectorCard.find('.direct-chat-messages'));
				}
				
				thisMain.renameChat(nameChannel);
			
				selectorCard.removeClass('direct-chat-contacts-open');
			} else {
				selectorCard.find('.direct-chat-messages').html('');
			}
			
			selectorCard.find('.overlay').remove();
		};

		selectorCard.append('\
			<div class="overlay dark">\
                <i class="fas fa-2x spinner-border"></i>\
            </div>\
		');

		formData = new FormData();
		
		formData.append('_token', config.token);
		formData.append('type', type);
		formData.append('id', id);
		formData.append('read', (selectorCard.find('.direct-chat-messages').is(":visible") == true) ? 1 : '');
		
		if(nextPage) {
			formData.append('next_page', nextPage);
		}
		
		Main.ajaxRequest('POST', config.route.chat_select_channel, formData, successEvent, errorHandle);
		
		return true;
	},
	
	noteNewMesages: function(dataCountNewMessages, selectorCard, countMsg, type) {
		let thisMain = this
			cardHeader = selectorCard.find('.card-header');
		
		if(!type) {
			thisMain.countNewMessages = {
				'general' : 0,
			};
		}
		
		$.each(dataCountNewMessages, function( channel, data ) {
			if(channel == 'general') {
				countMsg += parseInt(data);
				
				if(type && type == 'add') {
					thisMain.countNewMessages['general'] += parseInt(data);
				} else {
					thisMain.countNewMessages['general'] = parseInt(data);
				}
				
				cardHeader.find('span[data-widget="chat-pane-toggle"]').attr('data-original-title', (thisMain.countNewMessages['general'] > 0) ? 'В общем чате новых сообщений: ' + thisMain.countNewMessages['general'] : '');
			} else {
				if(data) {
					
					let notOriginal = {},
						selectChannel = selectorCard.find('#chat_' + channel);
					
					$.each(data, function( k, channelData ) {
						let optionEl = selectChannel.find('option[value="' + channelData['c_id'] + '"]');
						
						countMsg += parseInt(channelData['count']);
						
						let keyChannel = 'chat_' + channel + channelData['c_id'];
						
						if(!thisMain.countNewMessages[keyChannel] || !type) {
							thisMain.countNewMessages[keyChannel]= 0;
						}
						
						thisMain.countNewMessages[keyChannel] += parseInt(channelData['count']);
						
						if(optionEl.data('orig-text')) {
							optionEl.text(optionEl.data('orig-text') + ' (' + thisMain.countNewMessages[keyChannel] + ')');
						} else {
							optionEl.attr('data-orig-text', optionEl.text());
							optionEl.text(optionEl.text() + ' (' + thisMain.countNewMessages[keyChannel] + ')');
						}
						
						notOriginal[channelData['c_id']] = thisMain.countNewMessages[keyChannel];
					});
					
					if(!type) {
						
						selectChannel.find('option[data-orig-text]').each(function() {
							let optionFind = $(this);
							
							if(!notOriginal[optionFind.val()]) {
								optionFind.text(optionFind.data('orig-text'));
								optionFind.removeAttr('data-orig-text');
							}
						});
					}
					
					let select2Instance = selectChannel.data('select2');
					if(select2Instance) {
						let resetOptions = select2Instance.options.options;
						selectChannel.select2('destroy').select2(resetOptions);
					}
					
					if(data.length > 0) {
						selectChannel
							.closest('.form-group')
							.find('.select2-selection')
							.css('border-color','#17a2b8');
					}
				}
			}
		});
		
		if(countMsg > 0) {
			cardHeader.find('span[data-widget="chat-pane-toggle"]').text(countMsg).show();
			cardHeader.find('button[data-widget="chat-pane-toggle"]').hide();
		} else {
			cardHeader.find('span[data-widget="chat-pane-toggle"]').text('').hide();
			cardHeader.find('button[data-widget="chat-pane-toggle"]').show();
		}
	},
	
	chatCollectMessage: function(data, authId) {
		return '<div class="direct-chat-msg ' + ((data['sender_user_id'] == authId) ? 'right' : '') + '">\
					<div class="direct-chat-infos clearfix">\
						<span class="direct-chat-name float-' + ((data['sender_user_id'] == authId) ? 'right' : 'left') + '">' + data['sender_user']['full_name'] + '</span>\
						<span class="direct-chat-timestamp float-' + ((data['sender_user_id'] == authId) ? 'left' : 'right') + '">' + data['created_at'] + '</span>\
					</div>\
					<div class="direct-chat-text" style="' + ((data['sender_user_id'] == authId) ? 'margin-right: 1px;' : 'margin: 5px 0 0 0px') + '">\
						' + data['text'] + '\
					</div>\
				</div>';
	},
	
	unsubscribeChannel: function(Pusher){
		let thisMain = this;
		
		if (thisMain.currentChannel !== null) {
			Pusher.unsubscribe(thisMain.currentChannel.name);
			thisMain.currentChannel = null;
		}
		
		return true;
	},
	
	listenUserChannel: function(Pusher, authId, toUserId){
		if(Pusher && authId && toUserId){
			let thisMain = this;
			
			let channelId = [authId, toUserId].sort(function(a, b) {
			  return a - b;
			}).join('.');
			
			thisMain.currentChannel = Pusher.subscribe('private-chat-user.' + channelId);
			
			thisMain.bindNewMessage(authId);
			
            return true;
        }
        return false;
	},
	
	listenStructuralUnitChannel: function(Pusher, authId, groupId){
		if(Pusher && authId && groupId){
			let thisMain = this;
			
			thisMain.currentChannel = Pusher.subscribe('private-chat-structural-unit.' + groupId);
			
			thisMain.bindNewMessage(authId);
			
            return true;
        }
        return false;
	},
	
	listenGeneralChannel: function(Pusher, authId){
		if(Pusher && authId){
			let thisMain = this;
			thisMain.currentChannel = Pusher.subscribe('private-chat-general');
			
			thisMain.bindNewMessage(authId);
			
			thisMain.selectChannel(authId, '', '');
			
            return true;
        }
        return false;
	},
	
	bindNewMessage: function(authId) {
		let thisMain = this;
		
		thisMain.currentChannel.bind('newMessage', function (data) {
			if(data) {
				let directChatMessages = $('#chat_widget').find('.direct-chat-messages');
							
				directChatMessages.append(thisMain.chatCollectMessage(data, authId));
					
				thisMain.scrolDirectMessagesBottom(directChatMessages);
				
				if(directChatMessages.is(":visible")) {
					thisMain.requestReadMessages();
				}
			}
		});
		
		return true;
	},
	
	scrolDirectMessagesBottom: function(directChatMessages) {
		let dataDCM = directChatMessages[0];
					
        dataDCM.scrollTop = dataDCM.scrollHeight;
		
		return true;
	},
	
    sendMessage: function(event){
        if(event){
			event.preventDefault();

            let thisMain = this,
				selectorForm = $('#chat_form'),
                selectorButton = selectorForm.find('button[type="submit"]'),
				buttonHtml = selectorButton.html();

            let errorHandle = function(jqXHR, textStatus, errorThrown ){
                let data = jqXHR.responseJSON;

                if(data['errors'] && data['message']){
                    Main.displayAllErrors(data['errors'], selectorForm);
                } else {
                    Main.popUp('Произошла ошибка при отправке сообщения, обратитесь к администратору');
                }

				selectorButton.html(buttonHtml);
            };

            let successEvent = function(arrayData){
                if(arrayData['status'] && arrayData['status'] == 'success'){
					selectorForm.find('input[name="text"]').val('');
					
					Main.clearAllMessages(selectorForm);
                } else {
                    Main.popUp('Произошла ошибка при отправке сообщения, обратитесь к администратору');
                }
				
				selectorButton.html(buttonHtml);
            };

            formData = new FormData(selectorForm[0]);
			
            selectorButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

            Main.ajaxRequest('POST', selectorForm.attr('action'), formData, successEvent, errorHandle);

            return true;
        }
        return false;
    },

	actionCollapseWidget: function() {
		let widget = $('#chat_widget'),
			thisMain = this;
		
		if(!widget.find('.direct-chat-messages').is(":visible")) {
			thisMain.requestReadMessages();
			
		}
		
		return true;
	},
	
	requestReadMessages: function() {
		let widget = $('#chat_widget'),
			thisMain = this;

		let activeSelect = widget.find('.direct-chat-contacts').find('select').filter(
			function () {
				return parseInt(this.value) > 0; 
			}
		);
				
		if(thisMain.countNewMessages[activeSelect.length ? activeSelect.attr('id') + activeSelect.val() : 'general'] > 0) {
			let errorHandle = function(jqXHR, textStatus, errorThrown ){
				let data = jqXHR.responseJSON;
			};

			let successEvent = function(arrayData){
				if(arrayData['status'] && arrayData['status'] == 'success'){
					// thisMain.noteNewMesages(arrayData['newMessages'], widget.find('.card'), 0);
					
					return true;
				}
			};
			
			formData = new FormData();
			
			formData.append('_token', config.token);
			formData.append('type', activeSelect.attr('name') ? activeSelect.attr('name') : '');
			formData.append('id', activeSelect.val() ? activeSelect.val() : '');
			
			Main.ajaxRequest('POST', config.route.chat_read_msg, formData, successEvent, errorHandle);
		}
		
		return true;
	},
	
	notifyNewMessage: function(data) {
		let widget = $('#chat_widget'),
			thisMain = this;
			
		if(data) {
			let countMsg = parseInt(widget.find('.card-tools').find('span[data-widget="chat-pane-toggle"]').text());
			
			thisMain.noteNewMesages(
					data, 
					widget.find('.card'), 
					(countMsg) ? countMsg : 0, 
					'add'
				);
			
			return true;
		}
		return false;
	},
	
	updateCountNewMessages: function(data) {
		let widget = $('#chat_widget'),
			thisMain = this;
			
		if(data) {
			
			thisMain.noteNewMesages(data, widget.find('.card'), 0);
			
			return true;
		}
		return false;
	},
}
