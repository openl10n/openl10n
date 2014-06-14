define([
  'app',
  'tpl!apps/header/show/templates/layout'
], function(app, layoutTpl) {

  app.module('HeaderApp.Show.View', function(View, app, Backbone, Marionette, $, _) {
    View.Layout = Marionette.Layout.extend({
      template: layoutTpl,

      regions: {
      }
    });
  });

  return app.HeaderApp.Show.View;
});
