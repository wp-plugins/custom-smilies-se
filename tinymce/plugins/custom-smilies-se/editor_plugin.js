(function() {
	// Load plugin specific language pack
	//tinymce.PluginManager.requireLangPack('clcs');

	tinymce.create('tinymce.plugins.clcsPlugin', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand('mceclcs', function() {
				ed.windowManager.open({
					file : url + '/smilies.htm',
					width : parseInt(ed.getLang('clcs.delta_width', 0)),
					height : parseInt(ed.getLang('clcs.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register clcs button
			ed.addButton('clcs', {
				title : '{#clcs.clcs}',
				cmd : 'mceclcs',
				image : url + '/img/smile.gif'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				/*if (tinymce.DOM.getAttrib(ed.selection.getNode().parentNode, 'class') == "thickbox") {
					cm.setActive('clcs', true);
				} else {
					cm.setActive('clcs', false);
				}*/
			});
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Custom Smilies',
				author : 'Crazy Loong',
				authorurl : 'http://goto8848.net',
				infourl : 'http://goto8848.net/projects/custom-smilies/',
				version : "2.6"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('clcs', tinymce.plugins.clcsPlugin);
})();