define([
  'marionette',
  'tpl!apps/editor/translate/templates/filters',
], function(Marionette, filtersTpl) {

  return Marionette.ItemView.extend({
    template: filtersTpl
  });

});
