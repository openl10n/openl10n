var Marionette = require('backbone.marionette');

module.exports = Marionette.LayoutView.extend({
  template: require('../templates/editor-layout'),
  tagName: 'div',

  regions: {
    // languageOverlayRegion: '#language-overlay',
    sourceChooserRegion: '#source-chooser',
    targetChooserRegion: '#target-chooser',
    // resourcesListRegion: '#resources-list',
    // filtersRegion: '#filters',
    // actionBarRegion: '#actionbar',
    // statsRegion: '#stats',
    translationsListRegion: '#translations-list',
    // translationEditRegion: '#translations-edit'
  },

  behaviors: {
    Scrollable: {}
  }
});
