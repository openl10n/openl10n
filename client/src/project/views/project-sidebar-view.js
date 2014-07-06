var $ = require('jquery');
var Marionette = require('backbone.marionette');

module.exports = Marionette.ItemView.extend({
  template: require('../templates/project-sidebar'),
  tagName: 'div',
  className: 'sidebar-menu'
});
