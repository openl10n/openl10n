define([
  'marionette',
  'apps/project/show/views/resource_item',
  'tpl!apps/project/show/templates/resource_list'
], function(Marionette, ResourceItem, resourceListTpl) {

  return Marionette.CompositeView.extend({
    itemView: ResourceItem,
    template: resourceListTpl,
    //tagName: "ul",
    //className: "list-unstyled",
    itemViewContainer: "ul",
  });

});
