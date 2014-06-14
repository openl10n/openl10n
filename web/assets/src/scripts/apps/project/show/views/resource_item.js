define([
  'marionette',
  'tpl!apps/project/show/templates/resource_item'
], function(Marionette, resourceItemTpl) {

  return Marionette.ItemView.extend({
    template: resourceItemTpl,
    tagName: "li",
    className: "resources--item",
  });
});
