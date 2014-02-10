;(function(win, doc, Editor) {

  Editor.Views.TranslationListView = Backbone.Marionette.CollectionView.extend({
    itemView: Editor.Views.TranslationView,
    tagName: 'ul',
    className: 'list-unstyled',
  });


})(window, window.document, window.Editor)
