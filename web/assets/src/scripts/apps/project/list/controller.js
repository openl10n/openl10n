define(['app', 'apps/project/list/views'], function(app, View) {
  return function() {
    var layout = new View.Layout();
    app.mainRegion.show(layout);

    require(['entities/project/collection'], function() {
      var fetchingProjects = app.request('project:entities');

      $.when(fetchingProjects).done(function(projects) {
        var view = new View.ProjectList({collection: projects});
        layout.projectListRegion.show(view);
      });
    });
  }
});
