define([
  'app',
  'apps/editor/router',
  'apps/editor/controller'
], function(app, Router, Controller) {
  app.module('EditorApp', function(EditorApp, app, Backbone, Marionette, $, _) {
    EditorApp.startWithParent = false;

    EditorApp.onStart = function() {
      // Do something on module start
    };

    EditorApp.onStop = function() {
      // Do something on module stop
    };
  });

  // Init Router
  app.addInitializer(function() {
    var controller = new Controller();
    var router = new Router({controller: controller});
  });
});
