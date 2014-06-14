define([
  'marionette',
  'tpl!apps/project/show/templates/project_title'
], function(Marionette, projectTitleTpl) {

  return Marionette.ItemView.extend({
    template: projectTitleTpl,
    tagName: 'span',
    //className: 'x-project-show--project-header'
  });
});
