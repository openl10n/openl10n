define([
  'jquery',
  'backbone',
  'app',
  'entities/project/model',
  'apps/config/backend/router'
], function($, Backbone, app, Project, backendRouter) {

  var ProjectCollection = Backbone.Collection.extend({
    url: function() {
      return backendRouter.generate('openl10n_api_get_projects');
    },

    model: Project,
    comparator: 'name'
  });

  var API = {
    getProjectEntities: function() {
      var projects = new ProjectCollection();
      var defer = $.Deferred();

      projects.fetch({
        success: function(data) {
          defer.resolve(data);
        }
      });

      return defer.promise();
    }
  };

  app.reqres.setHandler('project:entities', function() {
    return API.getProjectEntities();
  });

  return ProjectCollection;
});
