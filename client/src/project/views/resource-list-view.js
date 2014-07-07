var Marionette = require('backbone.marionette');
var ResourceItemView = require('./resource-item-view');

module.exports = Marionette.CompositeView.extend({
  childView: ResourceItemView,
  template: require('../templates/resource-list'),
  childViewContainer: 'ul',
});
