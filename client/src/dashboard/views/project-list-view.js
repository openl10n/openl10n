var Marionette = require('backbone.marionette');
var ProjectItemView = require('./project-item-view');

module.exports = Marionette.CollectionView.extend({
  childView: ProjectItemView,
});
