define([
  'marionette',
  'tpl!bundle/editor/templates/actionbar',
], function(Marionette, actionbarTpl) {

  var ActionBarView = Marionette.ItemView.extend({
    template: actionbarTpl,

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

      var _this = this;
      require(['entities/translation/model'], function(Translation) {
        var translation = new Translation({
          text: _this.model.get('target_phrase'),
          approved: false
        });

        translation.id = _this.model.id;
        translation.locale = _this.model.get('target_locale');

        translation.save().done(function() {
          _this.model.set({
            'is_translated': true,
            'is_approved': false,
            'edited': false,
          });
        });
      });
    },

    approveTranslation: function() {
      if (!this.model.get('is_translated'))
        return;

      var _this = this;
      require(['entities/translation/model'], function(Translation) {
        var translation = new Translation({
          text: _this.model.get('target_phrase'),
          approved: true
        });

        translation.id = _this.model.id;
        translation.locale = _this.model.get('target_locale');

        translation.save().done(function() {
          _this.model.set({
            'is_approved': true
          });
        });
      });
    },

    unapproveTranslation: function() {
      if (!this.model.get('is_translated'))
        return;

      var _this = this;
      require(['entities/translation/model'], function(Translation) {
        var translation = new Translation({
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

  return ActionBarView;
});
