define([
  'marionette',
  'tpl!apps/editor/translate/templates/layout'
], function(Marionette, layoutTpl) {

  return Marionette.Layout.extend({
    template: layoutTpl,

    regions: {
      headerRegion: '#ol-editor-header',
      actionBarRegion: '#ol-editor-actionbar',
      filtersRegion: '#ol-editor-filters',
      translationEditRegion: '#ol-editor-translation-edit',
      translationListRegion: '#ol-editor-translation-list',
    },

    modelEvents: {
      "change": "modelChanged"
    },

    onShow: function() {
      var $window = $(window);
      var $el = this.$el.find('.js-fullheight');
      var updateBlockHeight = function UpdateBlockHeight() {
        var height = $window.height() - $el.offset().top;
        $el.height(height);
      }

      setTimeout(updateBlockHeight, 200); // hack
      $(window).resize(updateBlockHeight);
    },

    modelChanged: function() {

    }
  });

});
