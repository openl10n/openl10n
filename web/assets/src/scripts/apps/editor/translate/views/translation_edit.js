define([
  'marionette',
  'tpl!apps/editor/translate/templates/translation_edit',
], function(Marionette, translationEditTpl) {

  return Marionette.ItemView.extend({
    template: translationEditTpl
  });

});
