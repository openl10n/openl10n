define(['app', 'apps/header/show/show_view'], function(app, View) {
  app.module('HeaderApp.Show', function(Show, app, Backbone, Marionette, $, _) {

    Show.Controller = {
      showHeader: function() {
        // require(['entities/header'], function() {
        //   var links = app.request('header:entities');
        //   var headers = new View.Headers({collection: links});

        //   headers.on('brand:clicked', function() {
        //     app.trigger('contacts:list');
        //   });

        //   headers.on('itemview:navigate', function(childView, model) {
        //     var trigger = model.get('navigationTrigger');
        //     app.trigger(trigger);
        //   });

        //   app.headerRegion.show(headers);
        // });

        var layout = new View.Layout();
        app.headerRegion.show(layout);
      },

      // setActiveHeader: function(headerUrl) {
      //   var links = app.request('header:entities');
      //   var headerToSelect = links.find(function(header) { return header.get('url') === headerUrl; });
      //   headerToSelect.select();
      //   links.trigger('reset');
      // }
    };
  });

  return app.HeaderApp.Show.Controller;
});
