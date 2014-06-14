define([
  'underscore',
  'backbone',
  'marionette',
  'app',
  'msgbus',
  'bundle/editor/app',
  'bundle/editor/controller',
  'bundle/editor/router',
], function(_, Backbone, Marionette, app, msgbus, EditorApp, Controller, Router) {

  // Keep current editor as a global variable, so that it can be destruct easily
  var editorApp;

  // Use Marionette module to start and stop services
  app.module('EditorBundle', function(EditorBundle, app, Backbone, Marionette, $, _) {
    EditorBundle.startWithParent = false;

    EditorBundle.onStart = function() {
      // Do something on module start
    };

    EditorBundle.onStop = function() {
      // Free instanciate editor
      if (editorApp) {
        editorApp.destroy();
      }
    };
  });

  //
  // Init Router
  //
  app.addInitializer(function() {
    var controller = new Controller();
    var router = new Router({controller: controller});
  });

  //
  // Init events
  //
  msgbus.reqres.setHandler('editor:init', function(projectSlug) {
    var defer = $.Deferred();

    // If editor has already been initialized, then just return it (memoization)
    if (editorApp && editorApp.projectSlug === projectSlug) {
      defer.resolve(editorApp);
      return defer.promise();
    }

    // Start rendering project layout
    var renderingLayout = app.request('layout:project', projectSlug);
    $.when(renderingLayout).done(function(projectLayout) {
      // Then intialize editor layout
      editorApp = new EditorApp(projectSlug);
      editorApp.initialize(projectLayout.contentRegion);

      defer.resolve(editorApp);
    });

    return defer.promise();
  });

});
