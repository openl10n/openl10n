define([
  'jquery',
  'backbone',
  'backbone.select',
  'app',
  'apps/config/backend/router'
], function($, Backbone, BackboneSelect, app, backendRouter) {

  var Model = Backbone.Model.extend({
    //idAttribute: 'slug',

    url: function() {
      return backendRouter.generate('openl10n_api_get_translation_commit', {
        'source': this.get('source_locale'),
        'target': this.get('target_locale'),
        'translation': this.id
      });
    },

    defaults: {
      key: '',
      source_locale: '',
      source_phrase: '',
      target_locale: '',
      target_phrase: '',
      is_translated: false,
      is_approved: false,
      selected: false
    },

    initialize: function(options) {
      BackboneSelect.Me.applyTo(this);

      this.projectSlug = options.projectSlug;
      this.sourceLocale = options.sourceLocale;
      this.targetLocale = options.targetLocale;
    },
  });

  var API = {
    getEntity: function(translationId, source, target) {
      throw "Not implemented";

      var translationCommit = new Model({slug: projectSlug});
      var defer = $.Deferred();

      project.fetch({
        success: function(data) {
          defer.resolve(data);
        },
        error: function(data) {
          defer.resolve(undefined);
        }
      });

      return defer.promise();
    }
  };

  app.reqres.setHandler('translation_commit:entity', function(id) {
    return API.getEntity(id);
  });

  return Model;
});
