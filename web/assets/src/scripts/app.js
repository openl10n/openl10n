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
    // All navigation that is relative should be passed through the navigate
    // method, to be processed by the router. If the link has a `data-bypass`
    // attribute, bypass the delegation completely.
    $('body').on('click', 'a[href]:not([data-bypass])', function(evt) {
      // Get the absolute anchor href.
      // this.router.previousRoute = location.href;
      var href = {
        prop: $(this).prop("href"),
        attr: $(this).attr("href")
      };

      // Get the absolute root.
      var root = location.protocol + "//" + location.host;

      // Ensure the root is part of the anchor href, meaning it's relative.
      if (href.prop.slice(0, root.length) === root) {
        // Stop the default event to ensure the link will not cause a page
        // refresh.
        evt.preventDefault();
        // `Backbone.history.navigate` is sufficient for all Routers and will
        // trigger the correct events. The Router's internal `navigate` method
        // calls this anyways.  The fragment is sliced from the root.
        Backbone.history.navigate(href.attr, true);
      }
    });
  });

  // Default router
  app.addInitializer(function(options) {
    var DefaultRouter = Backbone.Router.extend({
      routes: {
        '': 'index'
      },

      index: function() {
        app.trigger('project:list');
      }
    });

    new DefaultRouter();
  });

  app.on('initialize:after', function(options) {
    require([
      'apps/common/init',
      'apps/project/app',
      'apps/editor/app',
    ], function () {
      // Start history
      if (!Backbone.history.started) {
        Backbone.history.start({pushState: true});
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
