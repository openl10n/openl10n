define(['app', 'apps/project/new/views'], function(app, View) {
  return function() {
    var layout = new View.Layout();
    app.mainRegion.show(layout);

    require(['entities/project/model'], function() {
      var newProject = app.request('project:entity:new');

      var formView = new View.ProjectForm({model: newProject});
      layout.projectFormRegion.show(formView);
    });
  }
});
