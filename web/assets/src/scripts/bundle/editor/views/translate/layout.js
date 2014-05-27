define([
  'marionette',
  'tpl!bundle/editor/templates/translate/layout',
], function(Marionette, translateLayoutTpl) {

  var TranslateLayoutView = Marionette.Layout.extend({
    template: translateLayoutTpl,

    ui: {
      textarea: 'textarea.phrase-editor'
    },

    regions: {
      tabsRegion: '#edit-tabs',
      informationTabRegion: '#tab-information',
      historyTabRegion: '#tab-history',
    },

    onShow: function() {
      // this.ui.textarea.get(0).focus();
      this.ui.textarea.select();
    }
  });

  return TranslateLayoutView;
});
