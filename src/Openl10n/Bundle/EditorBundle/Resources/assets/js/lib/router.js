;(function(win, doc, Editor) {

  Editor.Router = Backbone.Marionette.AppRouter.extend({
    appRoutes: {
      '': 'index',
      ':target': 'showLanguage',
      ':target/:domain': 'listTranslation',
      ':target/:domain/:hash': 'showTranslation',
      '*path': 'notFound'
    },

    initialize: function() {
      console.log('[DEBUG] router initialized');

      this.listenTo(Editor.context, 'change', this.updatePath);
    },

    // When context is updated, then update the current route,
    // but don't trigger any event as every component is listening
    // for context.
    // Routes are just here to initialize context first.
    updatePath: function() {
      var path = Editor.context.generatePath();
      Backbone.history.navigate(path, {trigger: false});
    }
  });
})(window, window.document, window.Editor)
