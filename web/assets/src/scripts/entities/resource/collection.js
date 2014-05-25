define([
  'jquery',
  'backbone',
  'app',
  'entities/resource/model',
  'apps/config/backend/router'
], function($, Backbone, app, Resource, backendRouter) {

  var ResourceCollection = Backbone.Collection.extend({
    url: function() {
      return backendRouter.generate('openl10n_api_get_resources', {
        project: this.projectSlug
      });
    },

    initialize: function(models, options) {
      //options = options || {};
      this.projectSlug = options.projectSlug;
    },

    model: Resource,
    comparator: 'pathname'
  });

  // var API = {
  //   getProjectEntities: function() {
  //     var projects = new ResourceCollection();
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

  return ResourceCollection;
});
