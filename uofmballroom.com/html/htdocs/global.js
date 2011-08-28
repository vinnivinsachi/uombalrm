// JavaScript Document

var settings ={
		messages: 'messages',
		statusSuccessColor: '#003399',
		messages_hide_delay: 0.5
};

var options={
	startcolor: settings.statusSuccessColor,
	endcolor: '#FFCC00',
	duration: 2
}

function init(e)
{
		//check if the messages element exists and is visible,
		//and if so, apply the highlight effect to it
		var messages =$(settings.messages);
		
		if(messages && messages.visible())
		{
			new Effect.Highlight(messages, options);
		}
		
		//new SearchSuggestor('search');
		
}

function message_write(message)
{
	var messages = $(settings.messages);
	if(!messages)
	{
		return;
	}
	
	if(message.length==0)
	{
		messages.hide();
		return;
	}
	
	messages.update(message);
	messages.show();
	new Effect.Highlight(messages, options);
	/*messages_clear();*/
}


function message_clear()
{
	setTimeout("message_write('')", settings.messages_hide_delay*1000);
}



Event.observe(window, 'load', init);