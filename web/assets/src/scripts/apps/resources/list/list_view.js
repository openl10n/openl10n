define(['app',
  'tpl!apps/resources/list/templates/layout',
  'tpl!apps/resources/list/templates/resource_item',
  'tpl!apps/resources/list/templates/language_item',
  'tpl!apps/resources/list/templates/stats'
], function(app, layoutTpl, resourceItemTpl, languageItemTpl, statsTpl) {

  app.module('ResourcesApp.List.View', function(View, app, Backbone, Marionette, $, _){
    View.Layout = Marionette.Layout.extend({
      template: layoutTpl,

      regions: {
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

    View.Stats = Marionette.ItemView.extend({
      template: statsTpl,

      onShow: function() {
        var $window = $(window);
        var $el = this.$el;
        function updateBlockHeight() {
          console.log('updateBlockHeight');
          console.log($el);
          var height = $window.height() - $el.offset().top;
          $el.height(height);
        }
        updateBlockHeight();
        $(window).resize(updateBlockHeight);
      }
    });
  });

  return app.ResourcesApp.List.View;
});
