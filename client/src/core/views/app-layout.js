var Marionette = require('backbone.marionette');

module.exports = Marionette.LayoutView.extend({
  template: require('../templates/app-layout'),
  el: 'body',
  className: 'app-layout',
  regions: {
    bodyRegion: 'div.body',
  }
})
