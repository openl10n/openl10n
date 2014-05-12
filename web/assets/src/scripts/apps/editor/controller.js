define(['marionette', 'app'], function(Marionette, app) {
  // To be replaced with a `beforeRouter` action
  var executeAction = function(action, arg) {
    app.startSubApp('EditorApp');
    action(arg);
  };

  return Marionette.Controller.extend({
    translate: function(projectSlug, source, target) {
      require(['apps/editor/translate/controller'], function(controller) {
        controller(projectSlug, source, target);
      });
    }
  });
});
