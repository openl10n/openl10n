define([
  'underscore',
  'backbone',
  'marionette',
  'app',
  'msgbus',
], function(_, Backbone, Marionette, app, msgbus) {

  var Controller = Marionette.Controller.extend({
    //
    // Translate mode
    //
    translate: function(projectSlug, source, target, translationId, filters) {
      return this._initialize('translate', projectSlug, source, target, translationId, filters);
    },

    //
    // Translate mode
    //
    proofread: function(projectSlug, source, target, translationId, filters) {
      return this._initialize('proofread', projectSlug, source, target, translationId, filters);
    },

    _initialize: function(mode, projectSlug, source, target, translationId, filters) {
      app.startSubApp('EditorBundle');

      var parameters = [source, target, translationId];
      for (var i in parameters) {
        var param = parameters[i];
        if (_.isObject(param)) {
          filters = param;
          break;
        }
      }

      var initializingEditorApp = msgbus.reqres.request('editor:init', projectSlug);
      $.when(initializingEditorApp).done(function(editorApp) {
        // Ensure editor is in "translate" mode
        editorApp.setMode(mode);

        // Set filters.
        editorApp.filters.set(filters)

        // Set context attributes.
        // Be sure to set context at the end in order to don't fetch
        // translations twice.
        editorApp.context.set({
          source: source || null,
          target: target || null,
        });

        // Select given translation
        if (translationId) {
          // TODO
        }
      });
    },

  });

  return Controller;

});
