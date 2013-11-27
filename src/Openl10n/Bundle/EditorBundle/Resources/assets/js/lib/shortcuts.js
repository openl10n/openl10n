;(function(win, doc, editor) {

  var ShortcutKeys = Backbone.Shortcuts.extend({
    shortcuts: {
      "ctrl+j" : "selectNextItem",
      "ctrl+k" : "selectPreviousItem",
    },

    selectNextItem: function() {
      editor.page.translationList.selectNextItem();
    },

    selectPreviousItem: function() {
      editor.page.translationList.selectPreviousItem();
    }
  });

  key.filter = function(event){
    var tagName = (event.target || event.srcElement).tagName;
    key.setScope(/^(INPUT|TEXTAREA|SELECT)$/.test(tagName) ? 'input' : 'all');
    return true;
  }

  editor.shortcuts = new ShortcutKeys;
})(window, window.document, window.editor)
