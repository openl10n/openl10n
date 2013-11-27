;(function(win, doc, editor) {

  editor.views.TranslationView = Backbone.Marionette.ItemView.extend({
    template: '#translation-item-template',
    tagName: 'li',

    initialize: function () {
      this.listenTo(this.model, 'change', this.render);
    },

    events: {
      'click a': function(evt) {
        evt.preventDefault();
        editor.page.set('hash', this.model.id);
      }
    }

  });

})(window, window.document, window.editor)
