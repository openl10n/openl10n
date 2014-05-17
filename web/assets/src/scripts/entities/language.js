define([
  'app',
  'apps/config/backend/router'
], function(app, backendRouter) {
  app.module('Entities', function(Entities, app, Backbone, Marionette, $, _) {
    Entities.Language = Backbone.Model.extend({
      url: function() {
        return backendRouter.generate('openl10n_api_get_project_languages', {
          'project': this.projectSlug,
        });
      },

      defaults: {
        name: '',
        locale: ''
      }
    });

    Entities.LanguageCollection = Backbone.Collection.extend({
      url: function() {
        return backendRouter.generate('openl10n_api_get_project_languages', {
          'project': this.projectSlug,
        });
      },

      initialize: function(models, options) {
        this.projectSlug = options.projectSlug;
      },

      model: Entities.Language,
      comparator: 'name'
    });

    var API = {
      getLanguagesEntities: function(projectSlug) {
        var languages = new Entities.LanguageCollection([], {projectSlug: projectSlug});
        var defer = $.Deferred();

        languages.fetch({
          success: function(data) {
            defer.resolve(data);
          },
          error: function() {
            alert('Unable to fetch language for project ' + projectSlug);
          }
        });

        var promise = defer.promise();

        return promise;
      }
    };

    app.reqres.setHandler('language:entities', function(projectSlug) {
      return API.getLanguagesEntities(projectSlug);
    });

    //app.reqres.setHandler('project:entity:new', function(id) {
    //  return new Entities.Project();
    //});
  });
});
