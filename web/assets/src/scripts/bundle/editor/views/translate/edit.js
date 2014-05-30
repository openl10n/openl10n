define([
  'marionette',
  'tpl!bundle/editor/templates/translate/edit',
], function(Marionette, translateEditTpl) {

  var EditView = Marionette.ItemView.extend({
    template: translateEditTpl,

    ui: {
      copy: '.action-copy',
      textarea: 'textarea.phrase-editor',
    },

    events: {
      'click @ui.copy': 'copySource',
      'keyup @ui.textarea': 'recordEditing',
    },

    modelEvents: {
      'change:source_phrase': 'render',
      'change:target_phrase': 'render',
      'change:is_translated': 'render',
      'change:is_approved': 'render',
    },

    onShow: function() {
      // this.ui.textarea.get(0).focus();
      this.ui.textarea.select();
    },

    copySource: function() {
      var phrase = this.model.get('source_phrase');
      this.model.set({
        'target_phrase': phrase,
        'edited': true
      });
    },

    recordEditing: function() {
      var previousText = this.model.get('target_phrase');
      var currentText = this.ui.textarea.val();

      if (previousText !== currentText) {
        this.model.set('target_phrase', currentText, {silent: true});
        this.model.set('edited', true);
      }
    }
  });

  return EditView;
});
