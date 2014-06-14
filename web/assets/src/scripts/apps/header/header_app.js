define(['app', 'apps/header/show/show_controller'], function(app, ShowController) {
  app.module('HeaderApp', function(Header, app, Backbone, Marionette, $, _) {
    var API = {
      showHeader: function() {
        ShowController.showHeader();
      }
    };

    // app.commands.setHandler('set:active:header', function(name) {
    //   ShowController.setActiveHeader(name);
    // });

    Header.on('start', function() {
      API.showHeader();
    });
  });

  return app.HeaderApp;
});
