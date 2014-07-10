var Marionette = require('backbone.marionette');

module.exports = Marionette.ItemView.extend({
  template: require('../templates/resource-item'),
  tagName: 'li',
});
