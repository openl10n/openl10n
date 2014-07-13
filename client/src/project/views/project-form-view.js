var $ = require('jquery');
var S = require('string');
var Backbone = require('backbone');
var Marionette = require('backbone.marionette');

module.exports = Marionette.ItemView.extend({
  template: require('../templates/project-form'),

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
      url: this.model.urlRoot,
      dataType: 'json',
      contentType: 'application/json',
      data: JSON.stringify(this.model)
    }).done(function() {
      Backbone.history.navigate('/', {trigger: true});
    }).fail(function() {
      alert('Project not save');
    });
  }
});
