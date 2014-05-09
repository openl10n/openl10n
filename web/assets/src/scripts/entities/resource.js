define([
  'app',
  'apps/config/backend/router'
], function(app, backendRouter) {
  app.module('Entities', function(Entities, app, Backbone, Marionette, $, _) {
    Entities.Resource = Backbone.Model.extend({
      url: function() {
        return backendRouter.generate('openl10n_api_get_resource', {
          'resource': this.id
        });
      },

      defaults: {
        pathname: '',
      },
    });

    Entities.ResourceCollection = Backbone.Collection.extend({
      url: function() {
        return backendRouter.generate('openl10n_api_get_resources', {
          project: this.projectSlug
        });
      },

      initialize: function(models, options) {
        //options = options || {};
        this.projectSlug = options.projectSlug;
      },

      model: Entities.Resource,
    });

    var API = {
      getResourceEntities: function(projectSlug) {
        var projects = new Entities.ResourceCollection([], {projectSlug: projectSlug});
        var defer = $.Deferred();

        projects.fetch({
          success: function(data) {
            defer.resolve(data);
          }
        });

        var promise = defer.promise();
        // $.when(promise).done(function(projects) {
        //   if(contacts.length === 0) {
        //     // if we don't have any contacts yet, create some for convenience
        //     var models = initializeContacts();
        //     contacts.reset(models);
        //   }
        // });

        return promise;
      },

      getResourceEntity: function(projectSlug, resourceId) {
        return null;
        var project = new Entities.Resource({id: projectSlug});
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

    app.reqres.setHandler('resource:entities', function(projectSlug) {
      return API.getResourceEntities(projectSlug);
    });

    app.reqres.setHandler('resource:entity', function(id) {
      return API.getResourceEntity(id);
    });

    app.reqres.setHandler('resource:entity:new', function(id) {
      return new Entities.Resource();
    });
  });
});
