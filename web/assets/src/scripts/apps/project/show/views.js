define([
  'apps/project/show/views/language_item',
  'apps/project/show/views/language_list',
  'apps/project/show/views/layout',
  'apps/project/show/views/project_title',
  'apps/project/show/views/resource_item',
  'apps/project/show/views/resource_list',
], function(LanguageItem, LanguageList, Layout, ProjectTitle, ResourceItem, ResourceList) {
  return {
    Layout: Layout,
    LanguageItem: LanguageItem,
    LanguageList: LanguageList,
    ProjectTitle: ProjectTitle,
    ResourceItem: ResourceItem,
    ResourceList: ResourceList,
  }
});
