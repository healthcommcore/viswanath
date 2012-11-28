var jceEditor = {
	pluginmode	: false,
	php			: true,
	javascript	: false,
	state 		: 'mceEditor',
	toggleText 	: '[show/hide]',
	allowToggle	: true,
	cleanup : function(type, content){
		switch(type){
			case 'insert_to_editor':
				var re 	= this.php ? '<script type="text/php">$2</script>' : '';
				content = content.replace(/<\?(\s+|php\s+)([^\?]*)\?>/gi, re);				
				if(!this.javascript){
					var re = this.php ? '(\s+type="text\/php")': '';
					content = content.replace(new RegExp('<script[^>'+re+']*>([.\r\n]*?)<\/script>', 'g'), '');
				}
				break;
			case 'get_from_editor':
				var re 	= this.php ? '<?php $1?>' : '';
				content = content.replace(/<script type="text\/php"><!--[\n\r]*(.*?)[\n\r]*\/\/\s+--><\/script>/g, re);
				content = content.replace(/<b>([^>]*)<\/b>/gi, '<strong>$1</strong>');
				content = content.replace(/<i>([^>]*)<\/i>/gi, '<em>$1</em>');
				break;
			case 'insert_to_editor_dom':
				break;
			case 'get_from_editor_dom':
				break;
		}
		return content;
	},
	save : function(content){
		if(this.pluginmode){
			content = content.replace(/&#39;/gi, "'");
			content = content.replace(/&apos;/gi, "'");
			content = content.replace(/&amp;/gi, "&");
			content = content.replace(/&quot;/gi, '"');
		}
		return content;
	},
	browser : function(field_name, url, type, win){	
		var ed = tinymce.EditorManager.activeEditor;
		ed.windowManager.open({
			file : ed.getParam('site_url') + '/index.php?option=com_jce&task=plugin&plugin=browser&file=browser&type=' + type,
			width : 750,
			height : 450,
			resizable : "yes",
        	inline : "yes",
        	close_previous : "no"
    	}, {
        	window : win,
        	input : field_name,
			url: url,
			type: type
    	});
		return false;
	},
	setCookie : function(id, state){
		tinymce.util.Cookie.set("jce_editor_state_"+  id, state);
	},
	getCookie : function(id){
		return tinymce.util.Cookie.get('jce_editor_state_'+id);
	},
	initEditorMode : function(id){
		var d = document;
		d.getElementById(id).className = this.state;
		if(this.allowToggle){			
			d.getElementById('editor_toggle_' + id).innerHTML = '<a href="javascript:jceEditor.toggleEditor(\''+ id +'\');">'+ this.toggleText +'</a>';
		}
		var state = this.getCookie(id);
		if(d.getElementById(id).className != state){
			switch(state){
				case 'mce_editable':
					d.getElementById(id).className = state;
					break;
				case 'mce_noteditable':
					d.getElementById(id).className = state;
				break;
			}
		}
	},
	toggleEditor : function(id) {
		if (tinyMCE.getInstanceById(id) == null){
			tinyMCE.execCommand('mceAddControl', false, id);
			this.setCookie(id, 'mce_editable');
		}else{
			tinyMCE.execCommand('mceRemoveControl', false, id);
			this.setCookie(id, 'mce_noteditable');
		}
	}
};