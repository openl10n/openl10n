define([
  'app',
  'tpl!apps/project/new/templates/layout',
  'tpl!apps/project/new/templates/project_form',
  'apps/config/backend/router'
], function(app, layoutTpl, projectFormTpl, backendRouter) {

  app.module('ProjectApp.New.View', function(View, app, Backbone, Marionette, $, _){
    View.Layout = Marionette.Layout.extend({
      template: layoutTpl,

      regions: {
        projectFormRegion: '#project-form'
      }
    });

    View.ProjectForm = Marionette.ItemView.extend({
      template: projectFormTpl,

      events: {
        'submit form': 'createProject'
      },

      ui: {
        form: 'form'
      },

      createProject: function(evt) {
        evt.preventDefault();
        var _this = this;

        var data = this.ui.form.serializeArray();

        // Set data on model
        _.each(data, function(attribute) {
          _this.model.set(attribute.name, attribute.value);
        });

        $.ajax({
          type: 'POST',
          url: backendRouter.generate('openl10n_api_get_projects'),
          dataType: 'json',
          contentType: 'application/json',
          data: JSON.stringify(this.model)
        }).done(function() {
          app.trigger('project:show', _this.model.id);
        }).fail(function() {
          alert('Project not save');
        });
      }
    });
  });

  return app.ProjectApp.New.View;
});
