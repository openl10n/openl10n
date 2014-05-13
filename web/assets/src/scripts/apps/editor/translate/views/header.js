define([
  'marionette',
  'tpl!apps/editor/translate/templates/header',
], function(Marionette, headerTpl) {

  return Marionette.ItemView.extend({
    template: headerTpl
  });

});
