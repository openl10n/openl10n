define([
  'marionette',
  'tpl!apps/editor/translate/templates/translation_list',
], function(Marionette, translationListTpl) {

  return Marionette.ItemView.extend({
    template: translationListTpl
  });

});
