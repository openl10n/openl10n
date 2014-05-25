define([
  'marionette',
  'bundle/editor/views/resource_item',
  'tpl!bundle/editor/templates/resources_list',
], function(Marionette, ResourceItem, resourceListTpl) {

  return Marionette.CompositeView.extend({
    itemView: ResourceItem,
    template: resourceListTpl,
    itemViewContainer: "ul",
  });

});
