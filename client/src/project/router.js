var Router = require('../framework/router');

module.exports = Router.extend({
  appRoutes: {
    'new': 'new',
    'projects/:projectSlug': 'index',
    'projects/:projectSlug/edit': 'edit',
  }
});
