define(['marionette', 'app'], function(Marionette, app) {
  // To be replaced with a `beforeRouter` action
  var executeAction = function(action, arg) {
    app.startSubApp('ProjectApp');
    action(arg);
  };

  return Marionette.Controller.extend({
    listProjects: function() {
      require(['apps/project/list/controller'], function(controller) {
        executeAction(controller);
      });
    },
    newProject: function() {
      require(['apps/project/new/new_controller'], function(NewController) {
        executeAction(NewController.newProject);
      });
    },
    showProject: function(projectSlug) {
      require(['apps/project/show/controller'], function(controller) {
        executeAction(controller, projectSlug);
      });
    }
  });
});
