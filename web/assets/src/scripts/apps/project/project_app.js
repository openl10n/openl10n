define(['app'], function(app) {
  app.module('ProjectApp', function(ProjectApp, app, Backbone, Marionette, $, _) {
    ProjectApp.startWithParent = false;

    ProjectApp.onStart = function() {
      //console.log('starting ProjectApp');
    };

    ProjectApp.onStop = function() {
      //console.log('stopping ProjectApp');
    };
  });

  app.module('Routers.ProjectApp', function(ProjectsAppRouter, app, Backbone, Marionette, $, _) {
    ProjectsAppRouter.Router = Marionette.AppRouter.extend({
      appRoutes: {
        'new': 'newProject',
        'projects': 'listProjects',
        'projects/:projectSlug': 'showProject'
      }
    });

    var executeAction = function(action, arg) {
      app.startSubApp('ProjectApp');
      action(arg);
      //app.execute('set:active:header', 'contacts');
    };

    var API = {
      listProjects: function() {
        require(['apps/project/list/list_controller'], function(ListController) {
          executeAction(ListController.listProjects);
        });
      },
      newProject: function() {
        require(['apps/project/new/new_controller'], function(NewController) {
          executeAction(NewController.newProject);
        });
      },
      showProject: function(projectSlug) {
        require(['apps/project/show/show_controller'], function(ShowController) {
          executeAction(ShowController.showProject, projectSlug);
        });
      }
    };

    // Event handler
    app.on('project:list', function() {
      app.navigate('projects');
      API.listProjects();
    });

    app.on('project:new', function(projectSlug) {
      app.navigate('projects/_new');
      API.newProject();
    });

    app.on('project:show', function(projectSlug) {
      app.navigate('projects/' + projectSlug);
      API.showProject(projectSlug);
    });

    // Init Router
    app.addInitializer(function() {
      new ProjectsAppRouter.Router({
        controller: API
      });
    });
  });

  return app.ProjectsAppRouter;
});
