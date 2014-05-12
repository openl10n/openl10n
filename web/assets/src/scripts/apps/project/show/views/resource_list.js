define([
  'marionette',
  'apps/project/show/views/resource_item'
], function(Marionette, ResourceItem) {

  return Marionette.CollectionView.extend({
    itemView: ResourceItem,
    tagName: "ul",
    className: "list-unstyled",
  });

});
