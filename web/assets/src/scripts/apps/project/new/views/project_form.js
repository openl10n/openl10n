define([
  'marionette',
  'string',
  'app',
  'tpl!apps/project/new/templates/project_form',
  'apps/config/backend/router'
], function(Marionette, S, app, projectFormTpl, backendRouter) {

  return Marionette.ItemView.extend({
    template: projectFormTpl,

    events: {
      'keyup @ui.inputName': 'updateSlug',
      'submit @ui.form': 'createProject'
    },

    ui: {
      form: 'form',
      inputName: 'input[name="name"]',
      inputSlug: 'input[name="slug"]',
    },

    updateSlug: function(evt) {
      console.log('update slug')
      var slug = S(this.ui.inputName.val()).slugify().s;
      this.ui.inputSlug.val(slug);
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
