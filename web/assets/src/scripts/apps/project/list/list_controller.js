define(['app', 'apps/project/list/list_view'], function(app, View) {
  app.module('ProjectApp.List', function(List, app, Backbone, Marionette, $, _) {
    List.Controller = {
      listProjects: function() {
        var layout = new View.Layout();
        app.mainRegion.show(layout);

        require(['entities/project'], function() {
          var fetchingProjects = app.request('project:entities');

          $.when(fetchingProjects).done(function(projects) {
            var view = new View.List({collection: projects});
            layout.projectListRegion.show(view);
          });
        });
      }
    }
  });

  return app.ProjectApp.List.Controller;
});
