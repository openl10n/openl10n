define([
  'app',
  'apps/config/backend/router'
], function(app, backendRouter) {
  app.module('Entities', function(Entities, app, Backbone, Marionette, $, _) {
    Entities.Resource = Backbone.Model.extend({
      url: function() {
        return backendRouter.generate('openl10n_api_get_project_resource', {
          'project': this.id,
          'resource': this.id
        });
      },

      defaults: {
        pathname: '',
      },
    });

    Entities.ResourceCollection = Backbone.Collection.extend({
      url: function() {
        return backendRouter.generate('openl10n_api_get_project_resources', {
          project: this.projectId
        });
      },

      initialize: function(models, options) {
        //options = options || {};
        this.projectId = options.projectId;
        console.log('projectId=' + this.projectId);
      },

      model: Entities.Resource,
    });

    var API = {
      getResourceEntities: function(projectId) {
        var projects = new Entities.ResourceCollection([], {projectId: projectId});
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

      getResourceEntity: function(projectId, resourceId) {
        return null;
        var project = new Entities.Resource({id: projectId});
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

    app.reqres.setHandler('resource:entities', function(projectId) {
      return API.getResourceEntities(projectId);
    });

    app.reqres.setHandler('resource:entity', function(id) {
      return API.getResourceEntity(id);
    });

    app.reqres.setHandler('resource:entity:new', function(id) {
      return new Entities.Resource();
    });
  });

  return;
});
