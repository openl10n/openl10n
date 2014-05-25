define([
  'jquery',
  'backbone',
  'app',
  'apps/config/backend/router'
], function($, Backbone, app, backendRouter) {

  var Resource = Backbone.Model.extend({
    idAttribute: 'slug',

    url: function() {
      return backendRouter.generate('openl10n_api_get_resource', {
        'resource': this.id,
      });
    },

    defaults: {
      pathname: '',
    }
  });

  // var API = {
  //   getProjectEntity: function(projectSlug) {
  //     var project = new Project({slug: projectSlug});
  //     var defer = $.Deferred();

  //     project.fetch({
  //       success: function(data) {
  //         defer.resolve(data);
  //       },
  //       error: function(data) {
  //         defer.resolve(undefined);
  //       }
  //     });

  //     return defer.promise();
  //   }
  // };

  // app.reqres.setHandler('project:entity', function(id) {
  //   return API.getProjectEntity(id);
  // });

  // app.reqres.setHandler('project:entity:new', function(id) {
  //   return new Project();
  // });

  return Resource;
});
