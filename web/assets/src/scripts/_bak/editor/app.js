define([
  'backbone',
  'marionette',
  'editor/translate/app'
], function(Backbone, Marionette, TranslateApp) {

  var app = new Marionette.Application();

  app.on('initialize:after', function(options) {
    // Start history
    if (!Backbone.history.started) {
      Backbone.history.start({pushState: false});
    }
  });

  // Initialize application
  app.addInitializer(function(options) {
    app.module('Translate', TranslateApp);
  });

  return app;
});
