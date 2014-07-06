var Marionette = require('backbone.marionette');

module.exports = Marionette.AppRouter.extend({
  appRoutes: {
    // Translate routes
    'projects/:projectSlug/translate': 'translate',
    'projects/:projectSlug/translate/:source': 'translate',
    'projects/:projectSlug/translate/:source/:target': 'translate',
    'projects/:projectSlug/translate/:source/:target/:translationId': 'translate',

    // Proofread routes
    'projects/:projectSlug/proofread': 'proofread',
    'projects/:projectSlug/proofread/:source': 'proofread',
    'projects/:projectSlug/proofread/:source/:target': 'proofread',
    'projects/:projectSlug/proofread/:source/:target/:translationId': 'proofread',
  }
});
