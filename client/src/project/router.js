var Router = require('../framework/router');

module.exports = Router.extend({
  appRoutes: {
    'projects/:projectSlug': 'index',
    'projects/:projectSlug/edit': 'edit',
  }
});
