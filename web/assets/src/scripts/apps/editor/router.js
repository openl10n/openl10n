define(['marionette'], function(Marionette) {
  var Router = Marionette.AppRouter.extend({
    appRoutes: {
      'projects/:projectSlug/translate0': 'translate',
      'projects/:projectSlug/translate0/:source': 'translate',
      'projects/:projectSlug/translate0/:source/:target': 'translate',
      'projects/:projectSlug/translate0/:source/:target/:translationId': 'translate',
    }
  });

  return Router;
});
