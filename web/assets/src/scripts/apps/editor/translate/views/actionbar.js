define([
  'marionette',
  'tpl!apps/editor/translate/templates/actionbar',
  'apps/config/backend/router'
], function(Marionette, actionbarTpl, backendRouter) {

  return Marionette.ItemView.extend({
    template: actionbarTpl,

    events: {
      'click .action-save': 'save',
      'click .action-approve': 'approve',
      'click .action-unapprove': 'unapprove',
      'click .action-skip': 'skip',
      'click .action-copy': 'copy',
      'click .action-undo': 'undo',
    },

    modelEvents: {
      'change': 'render'
    },

    save: function() {
      if (!this.model.get('target_phrase'))
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
          _this.model.set('is_translated', true);
        });
      });
    },

    approve: function() {
      if (!this.model.get('target_phrase'))
        return;

      console.log('approve translation');
      return;

      this.model.save({
        is_translated: true,
        is_approved: true
      });

      //msgBus.events.trigger('translations:select-next');
    },
    unapprove: function() {
      this.model.save({is_approved: false});
    },
    copy: function() {
      this.model.set({
        'target_phrase': this.model.get('source_phrase'),
        'is_dirty': true
      });
    },
    undo: function() {
      this.model.fetch();
    },
    skip: function() {
      //msgBus.events.trigger('translations:select-next');
    }
  });

});
