define([
  'jquery',
  'backbone',
  'app',
  'apps/config/backend/router'
], function($, Backbone, app, backendRouter) {

  var Model = Backbone.Model.extend({
    url: function() {
      return backendRouter.generate('openl10n_api_get_translation_phrases', {
        translation: this.id,
        locale: this.locale
      });
    },

    defaults: {
      text: '',
      approved: false
    }
  });

  return Model;
});
