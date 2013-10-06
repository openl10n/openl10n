;(function(win, doc, editor) {

  editor.views.TranslationListView = Backbone.Marionette.CollectionView.extend({
    itemView: editor.views.TranslationView,
    tagName: 'ul',
  });


})(window, window.document, window.editor)
