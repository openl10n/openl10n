define([
  'app',
  'apps/config/backend/router'
], function(app, backendRouter) {
  app.module('Entities', function(Entities, app, Backbone, Marionette, $, _) {
    Entities.Project = Backbone.Model.extend({
      url: function() {
        return backendRouter.generate('openl10n_api_get_project', {
          'project': this.id,
        });
      },

      defaults: {
        name: '',
        default_locale: 'en',
      },

      validate: function(attrs, options) {
        var errors = {};

        if (!attrs.name) {
          errors.name = 'cant be blank';
        }

        if (!_.isEmpty(errors)) {
          return errors;
        }
      }
    });

    Entities.ProjectCollection = Backbone.Collection.extend({
      url: function() {
        return backendRouter.generate('openl10n_api_get_projects');
      },

      model: Entities.Project,
      comparator: 'name'
    });

    var API = {
      getProjectEntities: function() {
        var projects = new Entities.ProjectCollection();
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

      getProjectEntity: function(projectId) {
        var project = new Entities.Project({id: projectId});
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

    app.reqres.setHandler('project:entities', function() {
      return API.getProjectEntities();
    });

    app.reqres.setHandler('project:entity', function(id) {
      return API.getProjectEntity(id);
    });

    app.reqres.setHandler('project:entity:new', function(id) {
      return new Entities.Project();
    });
  });

  return;
});
