var Marionette = require('backbone.marionette');

module.exports = Marionette.LayoutView.extend({
  template: require('../templates/site'),
  regions: {
    headerRegion: '#header',
    mainRegion: '#main',
  }
})
