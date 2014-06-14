define([
  'marionette',
  'tpl!apps/editor/translate/templates/translation_edit',
], function(Marionette, translationEditTpl) {

  return Marionette.ItemView.extend({
    template: translationEditTpl,

    modelEvents: {
      'change': 'render'
    },

    ui: {
      'editor': 'textarea.phrase-editor'
    },

    onRender: function() {
      var _this = this;

      // Require focus on textarea
      this.ui.editor.focus();

      this.ui.editor.on('keyup', function() {
        var text = $(this).val();
        var currentPhrase = _this.model.get('target_phrase');

        if (text != currentPhrase) {
          _this.model.set({
            'target_phrase': text,
            'is_dirty': true
          }, {silent: true});
          _this.model.trigger('edited');
        }
      });
    },
  });

});
