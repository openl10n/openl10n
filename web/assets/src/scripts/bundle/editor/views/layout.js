define([
  'marionette',
  'tpl!bundle/editor/templates/layout',
], function(Marionette, layoutTpl) {

  var Layout = Marionette.Layout.extend({
    template: layoutTpl,
    tagName: 'div',

    regions: {
      languageOverlayRegion: '#language-overlay',
      sourceChooserRegion: '#source-chooser',
      targetChooserRegion: '#target-chooser',
      resourcesListRegion: '#resources-list',
      filtersRegion: '#filters',
      actionBarRegion: '#actionbar',
      statsRegion: '#stats',
      translationsListRegion: '#translations-list',
      translationEditRegion: '#translations-edit'
    },

    behaviors: {
      Scrollable: {}
    },

    onShow: function() {
      var _this = this;

      this.$('.sidebar').hover(function() {
        _this.$el.addClass('sidebar-hover');
      }, function() {
        _this.$el.removeClass('sidebar-hover');
      })
    }
  });

  return Layout;
});
