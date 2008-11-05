tinyMCEPopup.requireLangPack();

var SmiliesDialog = {
	init : function(ed) {
		tinyMCEPopup.resizeToInnerSize();
	},

	insert : function(keycode) {
		var ed = tinyMCEPopup.editor, dom = ed.dom;

		tinyMCEPopup.execCommand('mceInsertContent', false, ' '+keycode+' ');

		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(SmiliesDialog.init, SmiliesDialog);