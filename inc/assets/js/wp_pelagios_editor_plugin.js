/**
 * Pelagios Widgets for WordPress
 *
 * TinyMCE 4.0 editor plugin, requires WordPress 3.9 or higher
 */
(function(){
    tinymce.PluginManager.add('wp_pelagios_mce_button', function( editor, url ){
        editor.addButton( 'wp_pelagios_mce_button',{
            text: false,
            icon: 'wp-pelagios-mce-button',
            type: 'menubutton',
            menu: [
                {
                    text: 'Pelagios Place Widget',
                    onclick: function(){
                        editor.windowManager.open({
                            title: 'Pelagios Place Widget',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'textID',
                                    label: 'Pelagios ID',
                                }
                            ],
                            onsubmit: function(e){
                                editor.insertContent('[pelagios id="' + e.data.textID + '"]');
                            }
                        });
                    }
                },
                {
                    text: 'Pelagios Search Widget',
                    onclick: function(){
                        editor.insertContent('[pelagios_search]');
                    }
                }
            ]
        });
    });
})();

/* end of file wp_pelagios_editor_plugin.js */