var Marionette = require('backbone.marionette');

module.exports = Marionette.LayoutView.extend({
  template: require('../templates/create-project'),

  regions: {
    projectFormRegion: '#project-form'
  }
});
