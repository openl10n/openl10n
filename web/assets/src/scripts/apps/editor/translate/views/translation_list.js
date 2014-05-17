define([
  'marionette',
  'apps/editor/translate/views/translation_item',
], function(Marionette, TranslationItem) {

  return Marionette.CollectionView.extend({
    itemView: TranslationItem,
    tagName: "ul",
    className: "list-unstyled"
  });

});
