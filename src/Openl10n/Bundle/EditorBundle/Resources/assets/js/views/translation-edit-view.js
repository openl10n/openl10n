;(function(win, doc, editor) {

  editor.views.TranslationEditView = Backbone.Marionette.ItemView.extend({
    template: '#translation-edit-template',

    ui: {
      'editor': 'textarea.phrase-editor'
    },

    initialize: function () {
      this.listenTo(this.model, 'change', this.render);
    },

    render: function() {
      Backbone.Marionette.ItemView.prototype.render.apply(this, arguments);
    },

    onRender: function() {
      var _this = this;

      this.ui.editor.on('keyup', function() {
        var text = $(this).val();
        _this.model.set('target_phrase', text, {silent: true});
      });
    }

  });

})(window, window.document, window.editor)
