var Marionette = require('backbone.marionette');

module.exports = Marionette.ItemView.extend({
  template: require('../templates/translation-meta-tabs'),

  ui: {
    tab: 'li > a'
  },

  events: {
    'click @ui.tab': 'displayTabContent'
  },

  displayTabContent: function(evt) {
    evt.preventDefault();
  }
});
