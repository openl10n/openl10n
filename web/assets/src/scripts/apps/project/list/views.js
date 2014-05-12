define([
  'apps/project/list/views/layout',
  'apps/project/list/views/project_list',
  'apps/project/list/views/project_item'
], function(Layout, ProjectList, ProjectItem) {

  return {
    Layout: Layout,
    ProjectList: ProjectList,
    ProjectItem: ProjectItem
  }

});
