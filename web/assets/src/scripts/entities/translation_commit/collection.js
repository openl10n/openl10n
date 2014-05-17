define([
  'jquery',
  'backbone',
  'backbone.select',
  'app',
  'entities/translation_commit/model',
  'apps/config/backend/router'
], function($, Backbone, BackboneSelect, app, Model, backendRouter) {

  var Collection = Backbone.Collection.extend({
    url: function() {
      return backendRouter.generate('openl10n_api_get_translation_commits', {
        'project': this.projectSlug,
        'source': this.sourceLocale,
        'target': this.targetLocale,
      });
    },

    initialize: function(models, options) {
      BackboneSelect.One.applyTo(this, models, options);

      this.projectSlug = options.projectSlug;
      this.sourceLocale = options.sourceLocale;
      this.targetLocale = options.targetLocale;
    },

    model: Model,
    //comparator: 'name'
  });

  var API = {
    getEntities: function(projectSlug, source, target) {
      var translationCommits = new Collection([], {
        projectSlug: projectSlug,
        sourceLocale: source,
        targetLocale: target
      });

      var defer = $.Deferred();

      translationCommits.fetch({
        success: function(data) {
          defer.resolve(data);
        }
      });

      return defer.promise();
    }
  };

  app.reqres.setHandler('translation_commit:entities', function(projectSlug, source, target) {
    return API.getEntities(projectSlug, source, target);
  });

  return Collection;
});
