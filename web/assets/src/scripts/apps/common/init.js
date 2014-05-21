define([
  'app',
  'apps/common/views/project_layout',
], function(app, ProjectLayout) {

  var cacheProjectLayout = {};
  var renderProjectLayout = function RenderProjectLayout(projectSlug) {
    var defer = $.Deferred();

    // Layout Memoization
    // Check if layout has already been instancied and that it's the current showed view
    if (cacheProjectLayout[projectSlug] && app.mainRegion.currentView === cacheProjectLayout[projectSlug]) {
      defer.resolve(cacheProjectLayout[projectSlug]);
      return defer.promise();
    }

    require(['entities/project/model'], function() {
      var fetchingProject = app.request('project:entity', projectSlug);

      $.when(fetchingProject).done(function(project) {
        var layout = new ProjectLayout({model: project});
        app.mainRegion.show(layout);

        // Memoize layout
        cacheProjectLayout[projectSlug] = layout;

        defer.resolve(layout);
      });
    });

    return defer.promise();
  };

  app.reqres.setHandler('layout:project', renderProjectLayout);
});
