define([
  'marionette',
  'tpl!bundle/editor/templates/layout',
], function(Marionette, layoutTpl) {

  var Layout = Marionette.Layout.extend({
    template: layoutTpl,
    tagName: 'div',

    regions: {
      sourceChooserRegion: '#source-chooser',
      targetChooserRegion: '#target-chooser',
      resourcesListRegion: '#resources-list',
      filtersRegion: '#filters',
      actionBarRegion: '#actionbar',
      statsRegion: '#stats',
      translationsListRegion: '#translations-list',
      translationEditRegion: '#translations-edit'
    },

    onShow: function() {
      var _this = this;

      var $window = $(window);
      var $el = this.$el.find('.js-scrollable');
      var updateBlockHeight = function UpdateBlockHeight() {
        $el.each(function() {
          var $this = $(this);
          var height = $window.height() - $(this).offset().top;
          $(this).height(height);
        });
      }

      setTimeout(updateBlockHeight, 200); // hack
      $(window).resize(updateBlockHeight);

      this.$('.sidebar').hover(function() {
        _this.$el.addClass('sidebar-hover');
      }, function() {
        _this.$el.removeClass('sidebar-hover');
      })
    }
  });

  return Layout;
});
