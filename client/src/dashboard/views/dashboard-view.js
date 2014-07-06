var Marionette = require('backbone.marionette');

module.exports = Marionette.LayoutView.extend({
  template: require('../templates/dashboard'),
  regions: {
    projectListRegion: '#project-list',
  }
})
