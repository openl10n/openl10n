define(['marionette'], function(Marionette) {

  var TranslationEditView = Marionette.ItemView.extend({
    template: '#ol-editor-translation-edit-template',

    ui: {
      'editor': 'textarea.phrase-editor'
    },

    initialize: function () {
      this.listenTo(this.model, 'change', this.render);
    },

    onRender: function() {
      var _this = this;

      // Require focus on textarea
      this.ui.editor.focus();

      this.ui.editor.on('keyup', function() {
        var text = $(this).val();
        _this.model.set('target_phrase', text, {silent: true});
      });
    },
  });

  return TranslationEditView;
});
