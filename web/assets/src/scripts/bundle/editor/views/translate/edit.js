define([
  'marionette',
  'tpl!bundle/editor/templates/translate/edit',
], function(Marionette, translateEditTpl) {

  var EditView = Marionette.ItemView.extend({
    template: translateEditTpl,

    ui: {
      textarea: 'textarea.phrase-editor'
    },

    events: {
      'keyup @ui.textarea': 'recordEditing',
    },

    modelEvents: {
      'sync': 'render'
    },

    onRender: function() {
      // this.ui.textarea.get(0).focus();
      this.ui.textarea.select();
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
