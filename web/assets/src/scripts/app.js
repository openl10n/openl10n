define([
  'backbone',
  'marionette',
  'apps/config/marionette/regions/modal'
], function(Backbone, Marionette) {

  var app = new Marionette.Application();

  app.addRegions({
    headerRegion: "#header",

    mainRegion: "#main",

    modalRegion: Marionette.Region.Modal.extend({
      el: "#modal"
    })
  });

  // Initialize application
  app.addInitializer(function(options) {
    require([
      'apps/project/project_app',
    ], function () {
      // Start history
      if (!Backbone.history.started) {
        Backbone.history.start({pushState: false});
      }

      if (app.getCurrentRoute() === '') {
        app.trigger('project:list');
      }
    });
  });

  app.navigate = function(route, options) {
    options || (options = {});
    Backbone.history.navigate(route, options);
  };

  app.getCurrentRoute = function() {
    return Backbone.history.fragment;
  };

  app.startSubApp = function(appName, args) {
    var currentApp = appName ? app.module(appName) : null;

    if (app.currentApp === currentApp)
      return;

    if (app.currentApp)
      app.currentApp.stop();

    app.currentApp = currentApp;
    if (currentApp) {
      currentApp.start(args);
    }
  };

  return app;
});
