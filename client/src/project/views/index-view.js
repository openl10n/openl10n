var $ = require('jquery');
var Marionette = require('backbone.marionette');

module.exports = Marionette.LayoutView.extend({
  template: require('../templates/index'),
  tagName: 'div',
  className: 'inner',

  regions: {
    languageListRegion: '#languages-list',
    resourceListRegion: '#resource-list',
  },

  onShow: function() {
    var _this = this;

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
  }
});
