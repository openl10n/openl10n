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

  return TranslationEditView;
});
