define(['marionette'], function(Marionette) {

  var ActionsView = Marionette.ItemView.extend({
    template: '#ol-editor-actions-template',

    events: {
      'click .action-save': 'save',
      'click .action-approve': 'approve',
      'click .action-unapprove': 'unapprove',
      'click .action-copy': 'copy',
      'click .action-undo': 'undo',
    },

    initialize: function () {
      this.listenTo(this.model, 'change', this.render);
    },

    save: function() {
      this.model.save({
        is_translated: true,
        is_approved: false
      });
    },
    approve: function() {
      this.model.save({is_approved: true});
    },
    unapprove: function() {
      this.model.save({is_approved: false});
    },
    copy: function() {
      this.model.set('target_phrase', this.model.get('source_phrase'));
    },
    undo: function() {
      this.model.fetch();
    }
  });

  return ActionsView;
});
