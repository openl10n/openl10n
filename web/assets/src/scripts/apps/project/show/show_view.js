define(['app',
  'tpl!apps/project/show/templates/layout',
  'tpl!apps/project/show/templates/resource_item',
  'tpl!apps/project/show/templates/language_item',
  'tpl!apps/project/show/templates/stats'
], function(app, layoutTpl, resourceItemTpl, languageItemTpl, statsTpl) {

  app.module('ProjectApp.Show.View', function(View, app, Backbone, Marionette, $, _){
    View.Layout = Marionette.Layout.extend({
      template: layoutTpl,

      regions: {
        languageListRegion: '#languages-list',
        resourceListRegion: '#resource-list',
        statsRegion: '#stats',
      }
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
      className: "x-project-show--languages-list list-unstyled",
    });

    View.Stats = Marionette.ItemView.extend({
      template: statsTpl,

      onShow: function() {
        var $window = $(window);
        var $el = this.$el;
        function updateBlockHeight() {
          var height = $window.height() - $el.offset().top;
          $el.height(height);
        }
        updateBlockHeight();
        $(window).resize(updateBlockHeight);
      }
    });
  });

  return app.ProjectApp.Show.View;
});
