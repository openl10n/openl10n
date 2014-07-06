var Marionette = require('backbone.marionette');

module.exports = Marionette.AppRouter.extend({
  appRoutes: {
    'projects/:projectSlug': 'index',
    'projects/:projectSlug/edit': 'edit',
  }
});
