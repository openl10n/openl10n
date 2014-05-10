define(['app',
  'tpl!apps/project/list/templates/layout',
  'tpl!apps/project/list/templates/project_item',
], function(app, layoutTpl, itemTpl) {

  app.module('ProjectApp.List.View', function(View, app, Backbone, Marionette, $, _){
    View.Layout = Marionette.Layout.extend({
      template: layoutTpl,

      regions: {
        projectListRegion: '#project-list',
      }
    });

    View.Item = Marionette.ItemView.extend({
      template: itemTpl,

      events: {
        'click': 'showProject'
      },

      showProject: function() {
        app.trigger('project:show', this.model.id);
      }
    });

    View.List = Marionette.CollectionView.extend({
      itemView: View.Item,
    });
  });

  return app.ProjectApp.List.View;
});
