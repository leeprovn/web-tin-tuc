(function(){
tinymce.create('tinymce.plugins.isovnTinymce', {
    createControl: function(n, cm) {
        switch(n){
           case    "isovnTinymcebutton" :
               var b = cm.createButton('isovnTinymcebutton', {
                   title    :   'iSovn shortcodes',
                   image    :  pluginurltinymce +  'images/icon.png',
                   cmd      :   "isovnTinymceShortcodeWindow"
               })
               return b;
        }

        return null;
    },
    
    init : function(ed, url){
        ed.addCommand('isovnTinymceShortcodeWindow', function(){
                            /////// Now open php file
                            var win = window.dialogArguments || opener || parent || top;
                            
                            r = ed.windowManager.open({
                                url     : pluginurltinymce+'shortcode_select.php',
                                width   :   800,
                                height  :   450,
                                inline  :   1
                            });
                            
                            

        })
    },
	getInfo : function() {
		return {
			longname : 'Support Extend Tinymce Section',
			author : 'LeePro',
			authorurl : 'http://isovn.net',
			infourl : 'http://isovn.net',
			version : tinymce.majorVersion + "." + tinymce.minorVersion
		}
	}
});

// Register plugin with a short name
tinymce.PluginManager.add('isovnTinymce', tinymce.plugins.isovnTinymce);
})();
