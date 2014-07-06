var $ = require('jquery');
var Marionette = require('backbone.marionette');

module.exports = Marionette.LayoutView.extend({
  template: require('../templates/project-layout'),
  tagName: 'div',
  className: 'layout-fixed x-project-show x-editor--layout',

  regions: {
    sidebarRegion: '#sidebar',
    languageListRegion: '#languages-list',
    resourceListRegion: '#resource-list',
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
