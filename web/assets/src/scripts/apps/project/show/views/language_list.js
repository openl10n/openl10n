define([
  'marionette',
  'apps/project/show/views/language_item',
  'tpl!apps/project/show/templates/language_list',
], function(Marionette, LanguageItem, languageListTpl) {

  return Marionette.CompositeView.extend({
    itemView: LanguageItem,
    template: languageListTpl,
    //className: "list-unstyled x-project-show--languages-list",
    itemViewContainer: "ul"
  });

});
