define(['app'], function(app) {
  app.module('ProjectsApp', function(ProjectsApp, app, Backbone, Marionette, $, _) {
    ProjectsApp.startWithParent = false;

    ProjectsApp.onStart = function() {
      console.log('starting ProjectsApp');
    };

    ProjectsApp.onStop = function() {
      console.log('stopping ProjectsApp');
    };
  });

  app.module('Routers.ProjectsApp', function(ProjectsAppRouter, app, Backbone, Marionette, $, _) {
    ProjectsAppRouter.Router = Marionette.AppRouter.extend({
      appRoutes: {
        'projects': 'listProjects'
      }
    });

    var executeAction = function(action, arg) {
      app.startSubApp('ProjectsApp');
      action(arg);
      //app.execute('set:active:header', 'contacts');
    };

    var API = {
      listProjects: function() {
        require(['apps/projects/list/list_controller'], function(ListController) {
          executeAction(ListController.listProjects);
        });
      },
    };

    app.on('projects:list', function() {
      app.navigate('projects');
      API.listProjects();
    });

    app.addInitializer(function() {
      new ProjectsAppRouter.Router({
        controller: API
      });
    });
  });

  return app.ProjectsAppRouter;
});
