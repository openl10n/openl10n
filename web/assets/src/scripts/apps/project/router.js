define(['marionette'], function(Marionette) {
  var Router = Marionette.AppRouter.extend({
    appRoutes: {
      'new': 'newProject',
      'projects': 'listProjects',
      'projects/:projectSlug': 'showProject'
    }
  });

  return Router;
});
