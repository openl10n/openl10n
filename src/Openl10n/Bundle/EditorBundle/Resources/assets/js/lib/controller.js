;(function(win, doc, editor) {

  editor.Controller = Marionette.Controller.extend({
    initialize: function() {
    },

    home: function() {
      console.log('Home action');
    },

    listTranslation: function(target, domain) {
      editor.page.set({
        target: target,
        domain: domain
      });

      $
        .when(editor.page.listDeferred)
        .then(function() {
          var firstItem = editor.page.translationList.at(0);
          editor.page.set('hash', firstItem.id);
        });
    },

    showTranslation: function(target, domain, hash) {
      editor.page.set({
        target: target,
        domain: domain,
        hash: hash
      });

      $
        .when(editor.page.listDeferred, editor.page.itemDeferred)
        .then(function() {
          editor.page.translationList.selectItem();
        });
    },

    notFound: function() {
      console.log('Route not found');
    }
  });

})(window, window.document, window.editor)
