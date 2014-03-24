define(['marionette', 'editor/common/msgbus'], function(Marionette, msgBus) {

  var ActionsView = Marionette.ItemView.extend({
    template: '#ol-editor-actions-template',

    events: {
      'click .action-save': 'save',
      'click .action-approve': 'approve',
      'click .action-unapprove': 'unapprove',
      'click .action-skip': 'skip',
      'click .action-copy': 'copy',
      'click .action-undo': 'undo',
    },

    initialize: function () {
      this.listenTo(this.model, 'change', this.render);
      this.listenTo(this.model, 'edited', this.render);
    },

    save: function() {
      if (!this.model.get('target_phrase'))
        return;

      this.model.save({
        is_translated: true,
        is_approved: false
      });

      msgBus.events.trigger('translations:select-next');
    },
    approve: function() {
      if (!this.model.get('target_phrase'))
        return;

      this.model.save({
        is_translated: true,
        is_approved: true
      });

      msgBus.events.trigger('translations:select-next');
    },
    unapprove: function() {
      this.model.save({is_approved: false});
    },
    copy: function() {
      this.model.set({
        'target_phrase': this.model.get('source_phrase'),
        'is_dirty': true
      });
    },
    undo: function() {
      this.model.fetch();
    },
    skip: function() {
      msgBus.events.trigger('translations:select-next');
    }
  });

  return ActionsView;
});
