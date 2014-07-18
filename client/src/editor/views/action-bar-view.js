var Marionette = require('backbone.marionette');

var TranslationPhrase = require('../models/translation-phrase');

module.exports = Marionette.ItemView.extend({
  template: require('../templates/action-bar'),

  ui: {
    'save': '.action-save',
    'approve': '.action-approve',
    'unapprove': '.action-unapprove',
    'cancel': '.action-cancel',
  },

  events: {
    'click @ui.save': 'saveTranslation',
    'click @ui.approve': 'approveTranslation',
    'click @ui.unapprove': 'unapproveTranslation',
    'click @ui.cancel': 'cancelEditing',
  },

  modelEvents: {
    'change:edited': 'render',
    'change:is_translated': 'render',
    'change:is_approved': 'render',
  },

  saveTranslation: function() {
    if (!this.model.get('edited'))
      return;

    var translation = new TranslationPhrase({
      text: this.model.get('target_phrase'),
      approved: false
    });

    translation.id = this.model.id;
    translation.locale = this.model.get('target_locale');

    this.model.set({
      'is_translated': true,
      'is_approved': false,
      'edited': false,
    });

    translation.save().fail(function() {
      alert('Unable to save translation');
    });
  },

  approveTranslation: function() {
    if (!this.model.get('is_translated'))
      return;

    var translation = new TranslationPhrase({
      text: this.model.get('target_phrase'),
      approved: true
    });

    translation.id = this.model.id;
    translation.locale = this.model.get('target_locale');

    this.model.set({
      'is_approved': true
    });

    translation.save().fail(function() {
      alert('Unable to approve translation');
    });
  },

  unapproveTranslation: function() {
    if (!this.model.get('is_translated'))
      return;

    var _this = this;
    var translation = new TranslationPhrase({
      text: _this.model.get('target_phrase'),
      approved: false
    });

    translation.id = _this.model.id;
    translation.locale = _this.model.get('target_locale');

    translation.save().done(function() {
      _this.model.set({
        'is_approved': false
      });
    });
  },

  cancelEditing: function() {
    var _this = this;
    this.model.fetch().done(function() {
      _this.model.set({
        'edited': false
      });
    });
  }
});
