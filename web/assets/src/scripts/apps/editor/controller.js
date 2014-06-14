define(['marionette', 'app'], function(Marionette, app) {
  // To be replaced with a `beforeRouter` action
  var executeAction = function(action, arg) {
    app.startSubApp('Editor');
    action(arg);
  };

  return Marionette.Controller.extend({
    translate: function(projectSlug, source, target, translationId) {
      app.startSubApp('Editor');
      require(['apps/editor/translate/controller'], function(controller) {
        controller(projectSlug, source, target, translationId);
      });
    }
  });
});
