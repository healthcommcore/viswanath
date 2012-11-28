/**
 * $Id: editor_plugin_src.js 373 2007-11-12 17:57:47Z spocke $
 *
 * @author Moxiecode
 * @copyright Copyright © 2004-2007, Moxiecode Systems AB, All rights reserved.
 */

(function() {
	tinymce.create('tinymce.plugins.ImageManager', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mceImage', function() {
				var e = ed.selection.getNode();

				// Internal image object like a flash placeholder
				if (ed.dom.getAttrib(e, 'class').indexOf('mceItem') != -1)
					return;

				ed.windowManager.open({
					file : ed.getParam('site_url') + 'index.php?option=com_jce&task=plugin&plugin=imgmanager&file=imgmanager',
					width : 760 + ed.getLang('imgmanager.delta_width', 0),
					height : 660 + ed.getLang('imgmanager.delta_height', 0),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register buttons
			ed.addButton('image', {
				title : 'imgmanager.desc',
				cmd : 'mceImage',
				image : url + '/img/imgmanager.gif'
			});
		},

		getInfo : function() {
			return {
				longname : 'Image Manager',
				author : 'Ryan Demmer',
				authorurl : 'http://www.cellardoor.za.net',
				infourl : 'http://www.cellardoor.za.net/index2.php?option=com_content&amp;task=findkey&amp;pop=1&amp;lang=en&amp;keyref=imgmanager.about',
				version : '1.5.0'
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('imgmanager', tinymce.plugins.ImageManager);
})();