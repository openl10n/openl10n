define([
  'marionette',
  'tpl!bundle/editor/templates/actionbar',
], function(Marionette, actionbarTpl) {

  var ActionBarView = Marionette.ItemView.extend({
    template: actionbarTpl,

    ui: {
      'save': '.action-save',
      'approve': '.action-approve',
    },

    events: {
      'click @ui.save': 'saveTranslation',
      'click @ui.approve': 'approveTranslation',
    },

    saveTranslation: function() {
      console.log('Save translation ' + this.model.id);
    },

    approveTranslation: function() {
      console.log('Approve translation ' + this.model.id);
    }
  });

  return ActionBarView;
});
