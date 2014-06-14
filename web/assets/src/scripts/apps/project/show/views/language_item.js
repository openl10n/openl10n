define([
  'marionette',
  'tpl!apps/project/show/templates/language_item',
  'apps/config/data/locale_helper'
], function(Marionette, languageItemTpl, localeHelper) {

  return Marionette.ItemView.extend({
    template: languageItemTpl,
    tagName: "li",

    templateHelpers: {
      region_code: function(locale) {
        return localeHelper.getRegion(locale).toUpperCase();
      }
    },
  });

});
