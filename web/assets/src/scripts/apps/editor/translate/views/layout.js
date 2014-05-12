define([
  'marionette',
  'tpl!apps/editor/translate/templates/layout'
], function(Marionette, layoutTpl) {

  return Marionette.Layout.extend({
    template: layoutTpl,

    regions: {
    }
  });

});
