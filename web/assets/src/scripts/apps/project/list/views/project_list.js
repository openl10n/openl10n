define([
  'marionette',
  'apps/project/list/views/project_item'
], function(Marionette, ProjectItem) {

  return Marionette.CollectionView.extend({
    itemView: ProjectItem,
  });

});
