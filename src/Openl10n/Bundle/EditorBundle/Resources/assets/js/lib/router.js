;(function(win, doc, editor) {

  editor.Router = Backbone.Marionette.AppRouter.extend({
    appRoutes: {
      '': 'home',
      ':target/:domain': 'listTranslation',
      ':target/:domain/:hash': 'showTranslation',
      '*path': 'notFound'
    }
  });
})(window, window.document, window.editor)
