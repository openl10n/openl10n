define([
  'marionette',
  'tpl!bundle/editor/templates/translate/layout',
], function(Marionette, translationEditTpl) {

  var TranslationEditView = Marionette.Layout.extend({
    template: translationEditTpl,

    regions: {
      tabsRegion: '#edit-tabs',
      informationTabRegion: '#tab-information',
      historyTabRegion: '#tab-history',
    }
  });

  return TranslationEditView;
});
