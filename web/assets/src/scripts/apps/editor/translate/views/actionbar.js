define([
  'marionette',
  'tpl!apps/editor/translate/templates/actionbar',
], function(Marionette, actionbarTpl) {

  return Marionette.ItemView.extend({
    template: actionbarTpl
  });

});
