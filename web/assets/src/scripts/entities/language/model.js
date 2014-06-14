define([
  'jquery',
  'backbone',
  'app',
  'apps/config/backend/router'
], function($, Backbone, app, backendRouter) {

  var Language = Backbone.Model.extend({
    idAttribute: 'slug',

    url: function() {
      return backendRouter.generate('openl10n_api_get_project_language', {
        'projectSlug': this.projectSlug,
        'locale': this.get('locale')
      });
    },

    defaults: {
      name: '',
      locale: '',
    },

    initialize: function(options) {
      options = options || {};
      this.projectSlug = options.projectSlug;
    },
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

  return Language;
});
