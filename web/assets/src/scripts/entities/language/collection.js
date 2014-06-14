define([
  'jquery',
  'backbone',
  'app',
  'entities/language/model',
  'apps/config/backend/router'
], function($, Backbone, app, Language, backendRouter) {

  var LanguageCollection = Backbone.Collection.extend({
    url: function() {
      return backendRouter.generate('openl10n_api_get_project_languages', {
        project: this.projectSlug
      });
    },

    initialize: function(models, options) {
      options = options || {};
      this.projectSlug = options.projectSlug;
    },

    model: Language,
    comparator: 'name'
  });

  // var API = {
  //   getProjectEntities: function() {
  //     var projects = new LanguageCollection();
  //     var defer = $.Deferred();

  //     projects.fetch({
  //       success: function(data) {
  //         defer.resolve(data);
  //       }
  //     });

  //     return defer.promise();
  //   }
  // };

  // app.reqres.setHandler('project:entities', function() {
  //   return API.getProjectEntities();
  // });

  return LanguageCollection;
});
