define([
  'marionette',
  'tpl!bundle/editor/templates/resource_item'
], function(Marionette, resourceItemTpl) {

  return Marionette.ItemView.extend({
    template: resourceItemTpl,
    tagName: 'li',
  });

});
