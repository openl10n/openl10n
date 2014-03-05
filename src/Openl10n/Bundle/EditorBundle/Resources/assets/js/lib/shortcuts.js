;(function(win, doc, Editor) {

  var ShortcutKeys = Backbone.Shortcuts.extend({
    shortcuts: {
      "ctrl+down" : "selectNextItem",
      "ctrl+up" : "selectPreviousItem",
    },

    selectNextItem: function() {
      Editor.translations.selectNextItem();
    },

    selectPreviousItem: function() {
      Editor.translations.selectPreviousItem();
    }
  });

  key.filter = function(event){
    var tagName = (event.target || event.srcElement).tagName;
    key.setScope(/^(INPUT|TEXTAREA|SELECT)$/.test(tagName) ? 'input' : 'all');
    return true;
  }

  Editor.shortcuts = new ShortcutKeys;
})(window, window.document, window.Editor)
