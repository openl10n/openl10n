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
      var attributes = {
        'project': this.projectSlug,
        'source': this.context.get('source'),
        'target': this.context.get('target'),
      };

      // Manage filters
      if (null !== this.filters.get('translated')) {
        attributes.translated = this.filters.get('translated');
      }
      if (null !== this.filters.get('approved')) {
        attributes.approved = this.filters.get('approved');
      }
      if (this.filters.get('text')) {
        attributes.text = this.filters.get('text');
      }

      return backendRouter.generate('openl10n_api_get_translation_commits', attributes);
    },

    initialize: function(models, options) {
      BackboneSelect.One.applyTo(this, models, options);

      this.projectSlug = options.projectSlug;
      this.context = options.context;
      this.filters = options.filters;

      this.stats = {
        all: 0,
        untranslated: 0,
        unapproved: 0
      };
    },

    model: Model,
    //comparator: 'name',

    parse: function(response) {
      this.stats.all = response.length;
      this.stats.untranslated = _(response).where({'is_translated': false}).length;
      this.stats.unapproved = _(response).where({'is_translated': true, 'is_approved': false}).length;

      return response;
    },

    reset: function(models, options) {
      this.stats.all = 0;
      this.stats.untranslated = 0;
      this.stats.unapproved = 0;

      return Backbone.Collection.prototype.reset.call(this, models, options);
    }
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
