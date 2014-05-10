define(['app', 'apps/project/new/new_view'], function(app, View) {
  app.module('ProjectApp.New', function(New, app, Backbone, Marionette, $, _) {
    New.Controller = {
      newProject: function() {
        var layout = new View.Layout();
        app.mainRegion.show(layout);

        require(['entities/project/model'], function() {
          var newProject = app.request('project:entity:new');

          var formView = new View.ProjectForm({model: newProject});
          layout.projectFormRegion.show(formView);
        });
      }
    }
  });

  return app.ProjectApp.New.Controller;
});
