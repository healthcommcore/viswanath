CKEDITOR.plugins.add("multipleclickdialoghandler",{init:function(a){},afterInit:function(a){if(CKEDITOR.multipleclickdialoghandler)return;CKEDITOR.dialog.prototype.show=CKEDITOR.tools.override(CKEDITOR.dialog.prototype.show,function(a){return function(){if(this._.showLock)return;this._.showLock=1;a.call(this)}});CKEDITOR.dialog.prototype.hide=CKEDITOR.tools.override(CKEDITOR.dialog.prototype.hide,function(a){return function(){a.call(this);this._.showLock=0}});CKEDITOR.multipleclickdialoghandler=true}})