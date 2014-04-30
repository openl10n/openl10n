define(['app'], function(app) {
  app.module('ResourcesApp', function(ResourcesApp, app, Backbone, Marionette, $, _) {
    ResourcesApp.startWithParent = false;

    ResourcesApp.onStart = function() {
      console.log('starting ResourcesApp');
    };

    ResourcesApp.onStop = function() {
      console.log('stopping ResourcesApp');
    };
  });

  app.module('Routers.ResourcesApp', function(ResourcesAppRouter, app, Backbone, Marionette, $, _) {
    ResourcesAppRouter.Router = Marionette.AppRouter.extend({
      appRoutes: {
        'projects/:projectId': 'listResources'
      }
    });

    var executeAction = function(action, arg) {
      app.startSubApp('ResourcesApp');
      action(arg);
      //app.execute('set:active:header', 'contacts');
    };

    var API = {
      listResources: function(projectId) {
        require(['apps/resources/list/list_controller'], function(ListController) {
          executeAction(ListController.listResources, [projectId]);
        });
      },
    };

    app.on('resources:list', function(projectId) {
      app.navigate('projects/' + projectId);
      API.listResources(projectId);
    });

    app.addInitializer(function() {
      new ResourcesAppRouter.Router({
        controller: API
      });
    });
  });

  return app.ResourcesAppRouter;
});
