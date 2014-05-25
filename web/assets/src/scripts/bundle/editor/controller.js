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
    translate: function(projectSlug, source, target, translationId) {
      app.startSubApp('EditorBundle');

      var initializingEditorApp = msgbus.reqres.request('editor:init', projectSlug);
      $.when(initializingEditorApp).done(function(editorApp) {
        // Ensure editor is in "translate" mode
        editorApp.setMode('translate');

        // Set context attributes
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

    //
    // Proofread mode
    //
    proofread: function(projectSlug, source, target, translationId) {
      var initializingEditorApp = msgbus.reqres.request('editor:init', projectSlug);
      $.when(initializingEditorApp).done(function(editorApp) {
        // Ensure editor is in "translate" mode
        editorApp.setMode('translate');

        // Set context attributes
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
