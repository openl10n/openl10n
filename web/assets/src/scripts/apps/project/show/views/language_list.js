define([
  'marionette',
  'apps/project/show/views/language_item'
], function(Marionette, LanguageItem) {

  return Marionette.CollectionView.extend({
    itemView: LanguageItem,
    tagName: "ul",
    className: "list-unstyled x-project-show--languages-list",
  });

});
