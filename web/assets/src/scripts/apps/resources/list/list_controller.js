define(['app', 'apps/resources/list/list_view'], function(app, View) {
  app.module('ResourcesApp.List', function(List, app, Backbone, Marionette, $, _) {
    List.Controller = {
      listResources: function(projectId) {
        var layout = new View.Layout();
        app.mainRegion.show(layout);

        var statsView = new View.Stats();
        layout.statsRegion.show(statsView);



        require(['entities/resource'], function() {
          var fetchingResources = app.request('resource:entities', projectId);

          $.when(fetchingResources).done(function(resources) {
            console.log(resources);

            var resourcesView = new View.ResourceList({collection: resources});
            layout.resourceListRegion.show(resourcesView);
          });
        });
      }
    }
  });

  return app.ResourcesApp.List.Controller;
});
