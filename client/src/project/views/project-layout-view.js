var $ = require('jquery');
var Marionette = require('backbone.marionette');

module.exports = Marionette.LayoutView.extend({
  template: require('../templates/project-layout'),
  tagName: 'div',
  className: 'layout-fixed x-project-show x-editor--layout',

  regions: {
    sidebarRegion: '#sidebar',
    contentRegion: '#content',
  },

  onShow: function() {
    var _this = this;

    // Display briefly the sidebar
    this.$el.addClass('sidebar-hover');
    setTimeout(function() {
      _this.$el.removeClass('sidebar-hover');
    }, 200);

    this.$('.sidebar').hover(function() {
      _this.$el.addClass('sidebar-hover');
    }, function() {
      _this.$el.removeClass('sidebar-hover');
    })
  }
});
