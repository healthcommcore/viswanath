//Common scripts for JCE
//DOM utilities
var jce = {
	dom : {
		doc : document,
		/*
		 * Shortcut for document.getElementById
		 * @param {string/element} The element id or element
		 * @return {Element} the target element
		*/
		get : function(o){
			if(typeof o == 'string'){ 
				o = this.doc.getElementById(o);
			}
			return o;
		},
		/*
		 * Attribute getter/setter
		 * @param {string/element} The element id or element
		 * @param {string} The attribute name
		 * @param {string} The attribute value
		 * @return {string} Attribute value
		*/
		attr : function(o, a, v){
			if(typeof v != 'undefined'){
				return this.get(o).setAttribute(a, v);	
			}
			return this.get(o).getAttribute(a);
		},
		value : function(o, v){
			var n = this.get(o);
			if(!n){
				return;
			}
			if(typeof v != 'undefined'){				
				if(n.nodeName == 'SELECT'){
					return this.setSelect(o, v);	
				}
				return n.value = v;	
			}
			if(n.nodeName == 'SELECT'){
				return this.getSelect(o);	
			}
			return n.value;
		},
		style : function(o, s, v){
			if(typeof v != 'undefined'){
				return this.get(o).style.s = v;	
			}
			return this.get(o).style.s;
		},
		html : function(o, v){
			if(typeof v != 'undefined'){
				return this.get(o).innerHTML = v;	
			}
			return this.get(o).innerHTML;
		},
		ischecked : function(o){
			return this.get(o).checked;
		},
		check : function(o, b){
			return this.get(o).checked = b;		
		},
		disabled : function(o){
			return this.get(o).disabled ? true : false;
		},
		disable : function(o, b){
			return this.get(o).disabled = b;
		},
		hasClass : function(o, c){
			return tinyMCEPopup.dom.hasClass(o, c);
		},
		setClass : function(o, c){
			return this.get(o).className = c;
		},
		addClass : function(o, c){
			return tinyMCEPopup.dom.addClass(o, c);
		},
		removeClass : function(o, c){
			return tinyMCEPopup.dom.removeClass(o, c);
		},
		show : function(o){
			this.get(o).style.display = 'block';
		},
		hide : function(o){
			this.get(o).style.display = 'none';
		},
		getSelect : function(fn, v){
			var s = this.get(fn);
			if(!s){
				return;
			}
			return s.value;
		},
		/* From TinyMCE form_utils.js function, slightly modified.
		 * @author Moxiecode
 		 * @copyright Copyright � 2004-2008, Moxiecode Systems AB, All rights reserved.
		*/
		setSelect : function(fn, v, ac, ic){
			var s = this.get(fn);
			if(!s){
				return;
			}
			var found = false;
			for (var i=0; i<s.options.length; i++) {
				var o = s.options[i];
		
				if (o.value == v || (ic && o.value.toLowerCase() == v.toLowerCase())) {
					o.selected = true;
					found = true;
				} else{
					o.selected = false;
				}
			}	
			if (!found && ac && v != '') {
				this.addSelect(fn, v, v);
			}
			return found;
		},
		/* From TinyMCE form_utils.js function, slightly modified.
		 * @author Moxiecode
 		 * @copyright Copyright � 2004-2008, Moxiecode Systems AB, All rights reserved.
		*/
		addSelect : function(fn, n, v){
			var s = this.get(fn);
			var o = new Option(n, v);
			s.options[s.options.length] = o;
			s.selectedIndex = s.options.length - 1;
		}
	},
	string : {
		trim : function(s){
			return tinymce.trim(s);	
		},
		basename : function(s){
			s = s.replace(/\\/g, '/');
			return s.substring(s.length, s.lastIndexOf('/')+1);
		},
		dirname : function(s){
			return s.substring(0, s.lastIndexOf('/'));
		},
		filename : function(s){
			return this.stripExt(this.basename(s));
		},
		getExt : function(s){
			return s.substring(s.length, s.lastIndexOf('.')+1).toLowerCase();
		},
		stripExt : function(s){
			return s.replace(/\.[^.]*$/i, '');
		},
		pathinfo : function(s){
			var info = {
				'basename': 	this.basename(s),
				'dirname': 		this.dirname(s),
				'extension': 	this.getExt(s),
				'filename': 	this.filename(s)
			}
			return info;
		},
		path : function(a, b){			
			if(a.substring(a.length-1) != '/'){
				a += '/';
			}		
			if(b.charAt(0) == '/'){
				b = b.substring(1);
			}
			return a+b;
		},
		safe : function(s){
			s = s.replace(/[^a-z0-9\.\_\-\s]/gi, '').replace(/\s/gi, '_').toLowerCase();
			return this.basename(s);
		},
		query : function(s){
			var p = {};
			if(s){
				var n = s.split(/[;&?]/);
				for(var i = 0; i < n.length; i++ ){
					var kv = n[i].split('=');
					if( ! kv || kv.length != 2 ){ 
						continue;
					}
					var k = unescape( kv[0] );
					var v = unescape( kv[1] );
					v = v.replace(/\+/g, ' ');
					p[k] = v;
				}
			}
			return p;	
		},
		encode : function(s){
			return tinyMCEPopup.editor.dom.encode(s);
		},
		decode : function(s){
			return tinyMCEPopup.editor.dom.decode(s);
		},
		escape : function(s){
			// Already escaped? Avoid double escaping
			if(/%([0-9A-Z+])/i.test(s)){
				return s;	
			}
			return escape(s);
		},
		unescape : function(s){
			return unescape(s);
		},
		/* From TinyMCE form_utils.js function, slightly modified.
		 * @author Moxiecode
 		 * @copyright Copyright � 2004-2008, Moxiecode Systems AB, All rights reserved.
		*/
		toHex : function(color) {
			var re = new RegExp("rgb\\s*\\(\\s*([0-9]+).*,\\s*([0-9]+).*,\\s*([0-9]+).*\\)", "gi");
		
			var rgb = color.replace(re, "$1,$2,$3").split(',');
			if (rgb.length == 3) {
				r = parseInt(rgb[0]).toString(16);
				g = parseInt(rgb[1]).toString(16);
				b = parseInt(rgb[2]).toString(16);
		
				r = r.length == 1 ? '0' + r : r;
				g = g.length == 1 ? '0' + g : g;
				b = b.length == 1 ? '0' + b : b;
		
				return "#" + r + g + b;
			}
			return color;
		},
		/* From TinyMCE form_utils.js function, slightly modified.
		 * @author Moxiecode
 		 * @copyright Copyright � 2004-2008, Moxiecode Systems AB, All rights reserved.
		*/
		toRGB : function(color) {
			if (color.indexOf('#') != -1) {
				color = color.replace(new RegExp('[^0-9A-F]', 'gi'), '');
		
				r = parseInt(color.substring(0, 2), 16);
				g = parseInt(color.substring(2, 4), 16);
				b = parseInt(color.substring(4, 6), 16);
		
				return "rgb(" + r + "," + g + "," + b + ")";
			}
			return color;
		}
	}
}
// Global shortcuts
var dom = jce.dom, string = jce.string;

function changeDimensions(wo, ho) {
	var w = dom.value(wo);
	var h = dom.value(ho);
	
	if(!w || !h)
		return;
	
	if( !dom.ischecked('constrain'))
        return;
	
	var temp = (w / dom.value('tmp-' + wo)) * dom.value('tmp-' + ho);
	dom.value(ho, temp.toFixed(0));
	dom.value('tmp-' + ho, temp.toFixed(0));
	dom.value('tmp-' + wo, w);
};