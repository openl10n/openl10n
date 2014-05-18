define([
  'marionette',
  'tpl!apps/project/show/templates/layout'
], function(Marionette, layoutTpl) {

  return Marionette.Layout.extend({
    template: layoutTpl,
    tagName: 'div',
    className: 'layout-fixed x-project-show',

    regions: {
      projectTitleRegion: '#project-title',
      languageListRegion: '#languages-list',
      resourceListRegion: '#resource-list',
      statsRegion: '#stats',
    },

    onShow: function() {
      var _this = this;

      // Display briefly the sidebar
      this.$el.addClass('sidebar-hover');
      setTimeout(function() {
        _this.$el.removeClass('sidebar-hover');
      }, 200);

      var $window = $(window);
      var $el = this.$el.find('.js-scrollable');

      var updateBlockHeight = function UpdateBlockHeight() {
        if (!$el.length)
          return;

        var height = $window.height() - $el.offset().top;
        $el.height(height);
      }

      updateBlockHeight();
      $(window).resize(updateBlockHeight);

      this.$('.sidebar').hover(function() {
        _this.$el.addClass('sidebar-hover');
      }, function() {
        _this.$el.removeClass('sidebar-hover');
      })
    }
  });

});
