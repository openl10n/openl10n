define([
  'app',
  'apps/project/router',
  'apps/project/controller'
], function(app, Router, Controller) {
  app.module('ProjectApp', function(ProjectApp, app, Backbone, Marionette, $, _) {
    ProjectApp.startWithParent = false;

    ProjectApp.onStart = function() {
      // Do something on module start
    };

    ProjectApp.onStop = function() {
      // Do something on module stop
    };
  });

  // Init Router
  app.addInitializer(function() {
    var controller = new Controller();
    var router = new Router({controller: controller});

    // Event handler
    app.on('project:list', function() {
      app.navigate('projects');
      controller.listProjects();
    });

    app.on('project:new', function(projectSlug) {
      app.navigate('projects/_new');
      controller.newProject();
    });

    app.on('project:show', function(projectSlug) {
      app.navigate('projects/' + projectSlug);
      controller.showProject(projectSlug);
    });
  });
});
