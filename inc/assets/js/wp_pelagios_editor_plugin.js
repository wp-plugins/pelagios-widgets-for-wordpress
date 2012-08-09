(
	function(){	
		var icon_url = '../wp-content/plugins/pelagios-widgets-for-wordpress/inc/assets/images/wp_pelagios_icon.png';	
		tinymce.create(
			"tinymce.plugins.WpPelagiosShortcodes",
			{
				init: function(d,e) {},
				createControl:function(d,e)
				{				
					if(d=="wp_pelagios_shortcodes_button")
					{					
						d=e.createMenuButton( "wp_pelagios_shortcodes_button",{
							title:"Pelagios Shortcode",
							image:icon_url,
							icons:false
							});							
							var a=this;d.onRenderMenu.add(function(c,b)
							{						
								a.addImmediate(b,"Place", '[pelagios id=""]');
							});
						return d					
					}					
					return null
				},		
				addImmediate:function(d,e,a){d.add({title:e,onclick:function(){tinyMCE.activeEditor.execCommand( "mceInsertContent",false,a)}})}				
			}
		);		
		tinymce.PluginManager.add( "WpPelagiosShortcodes", tinymce.plugins.WpPelagiosShortcodes);
	}
)();