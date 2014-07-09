var $ = require('jquery');
var Marionette = require('backbone.marionette');
var msgbus = require('msgbus');

module.exports = Marionette.ItemView.extend({
  template: require('../templates/project-sidebar'),
  tagName: 'div',
  className: 'sidebar-menu',

  initialize: function() {
    this.listenTo(msgbus.vent, 'menu:project:select', this.selectMenu);
  },

  selectMenu: function(itemName) {
    this.$el.find('.sidebar-menu--item').removeClass('active');
    this.$el.find('.sidebar-menu--item[data-name="' + itemName + '"]').addClass('active');
  }
});
