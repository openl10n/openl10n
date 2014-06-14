define([
  'marionette',
  'apps/editor/translate/views/translation_list',
  'tpl!apps/editor/translate/templates/layout',
], function(Marionette, TranslationListView, layoutTpl) {

  return Marionette.Layout.extend({
    template: layoutTpl,
    tagName: 'div',
    className: '',

    regions: {
      headerRegion: '#ol-editor-header',
      actionBarRegion: '#ol-editor-actionbar',
      filtersRegion: '#ol-editor-filters',
      translationEditRegion: '#ol-editor-translation-edit',
      translationListRegion: '#translations-list',
    },

    modelEvents: {
      "change": "modelChanged"
    },

    initialize: function() {
      this.translationListView = new TranslationListView({collection: this.collection});
    },

    onRender: function() {
      this.translationListRegion.show(this.translationListView);
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
    },

    modelChanged: function() {

    }
  });

});
