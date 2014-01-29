;(function(win, doc, Editor) {

  Editor.Views.TranslationEditView = Backbone.Marionette.ItemView.extend({
    template: '#ol-editor-translation-edit-template',

    ui: {
      'editor': 'textarea.phrase-editor'
    },

    initialize: function () {
      this.listenTo(this.model, 'change', this.render);
    },

    onRender: function() {
      var _this = this;

      this.ui.editor.on('keyup', function() {
        var text = $(this).val();
        _this.model.set('target_phrase', text, {silent: true});
      });
    }

  });

})(window, window.document, window.Editor)
