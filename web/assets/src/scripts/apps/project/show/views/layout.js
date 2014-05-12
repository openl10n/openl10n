define([
  'marionette',
  'tpl!apps/project/show/templates/layout'
], function(Marionette, layoutTpl) {

  return Marionette.Layout.extend({
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

});
