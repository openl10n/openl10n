define([
  'marionette',
  'tpl!bundle/editor/templates/translate/layout',
], function(Marionette, translateLayoutTpl) {

  var TranslateLayoutView = Marionette.Layout.extend({
    template: translateLayoutTpl,

    regions: {
      tabsRegion: '#edit-tabs',
      informationTabRegion: '#tab-information',
      historyTabRegion: '#tab-history',
    }
  });

  return TranslateLayoutView;
});
