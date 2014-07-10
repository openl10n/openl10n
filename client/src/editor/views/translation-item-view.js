var Marionette = require('backbone.marionette');

module.exports = Marionette.ItemView.extend({
  template: require('../templates/translation-item'),
  tagName: 'li',
  className: 'translations-item',

  modelEvents: {
    'change': 'render',
    'selected': 'onSelect',
    'deselected': 'onDeselect',
  },

  templateHelpers: {
    //S: S
  },

  events: {
    'click': 'selectTranslation'
  },

  onRender: function() {
    if (this.model.selected)
      this.$el.addClass('active');
  },

  onSelect: function() {
    this.$el.addClass('active');
  },

  onDeselect: function() {
    this.$el.removeClass('active');
  },

  selectTranslation: function() {
    // this.model.select();
  },

});
