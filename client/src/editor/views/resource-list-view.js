var Marionette = require('backbone.marionette');
var ResourceItemView = require('./resource-item-view');

module.exports = Marionette.CompositeView.extend({
  template: require('../templates/resource-list'),
  childView: ResourceItemView,
  childViewContainer: 'ul',
});
