var $ = require('jquery');
var Marionette = require('backbone.marionette');

module.exports = Marionette.Behavior.extend({

  onShow: function() {
    var $window = $(window);
    var $el = this.view.$el.find('.js-scrollable');
    var updateBlockHeight = function UpdateBlockHeight() {
      $el.each(function() {
        var $this = $(this);
        var height = $window.height() - $this.offset().top;
        $this.height(height);
      });
    }

    updateBlockHeight();
    $window.resize(updateBlockHeight);
  }

});
