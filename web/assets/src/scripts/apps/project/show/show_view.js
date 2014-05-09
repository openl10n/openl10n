define(['app',
  'tpl!apps/project/show/templates/layout',
  'tpl!apps/project/show/templates/project_title',
  'tpl!apps/project/show/templates/resource_item',
  'tpl!apps/project/show/templates/language_item',
  'tpl!apps/project/show/templates/stats'
], function(app, layoutTpl, projectTitleTpl, resourceItemTpl, languageItemTpl, statsTpl) {

  app.module('ProjectApp.Show.View', function(View, app, Backbone, Marionette, $, _){
    View.Layout = Marionette.Layout.extend({
      template: layoutTpl,

      regions: {
        projectTitleRegion: '#project-title',
        languageListRegion: '#languages-list',
        resourceListRegion: '#resource-list',
        statsRegion: '#stats',
      },

      onShow: function() {
        var $window = $(window);
        var $el = this.$el.find('.js-fullheight');
        var updateBlockHeight = function UpdateBlockHeight() {
          var height = $window.height() - $el.offset().top;
          $el.height(height);
        }
        updateBlockHeight();
        $(window).resize(updateBlockHeight);
      }
    });

    View.ProjectTitle = Marionette.ItemView.extend({
      template: projectTitleTpl,
      className: 'x-project-show--project-header'
    });

    View.ResourceItem = Marionette.ItemView.extend({
      template: resourceItemTpl,
      tagName: "li",
    });

    View.ResourceList = Marionette.CollectionView.extend({
      itemView: View.ResourceItem,
      tagName: "ul",
      className: "list-unstyled",
    });

    View.LanguageItem = Marionette.ItemView.extend({
      template: languageItemTpl,
      tagName: "li",
    });

    View.LanguageList = Marionette.CollectionView.extend({
      itemView: View.LanguageItem,
      tagName: "ul",
      className: "list-unstyled x-project-show--languages-list",
    });

    View.Stats = Marionette.ItemView.extend({
      template: statsTpl
    });
  });

  return app.ProjectApp.Show.View;
});
