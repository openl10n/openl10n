define(['app',
  'tpl!apps/projects/list/templates/layout.tpl',
  'tpl!apps/projects/list/templates/project_item.tpl',
], function(app, layoutTpl, itemTpl) {

  app.module('ProjectsApp.List.View', function(View, app, Backbone, Marionette, $, _){
    View.Layout = Marionette.Layout.extend({
      template: layoutTpl,

      regions: {
        projectListRegion: '#project-list',
      }
    });

    View.Item = Marionette.ItemView.extend({
      template: itemTpl,
    });

    View.List = Marionette.CollectionView.extend({
      itemView: View.Item,
    });
  });

  return app.ProjectsApp.List.View;
});
