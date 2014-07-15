var Marionette = require('backbone.marionette');

module.exports = Marionette.ItemView.extend({
  template: require('../templates/filters'),
  tagName: 'span',

  ui: {
    'form': 'form',
    'input': 'input[type="text"]',
    'clear': '.clear',
  },

  modelEvents: {
    'change': 'render'
  },

  events: {
    'submit @ui.form': 'filterText',
    'click @ui.clear': 'clearText',
  },

  filterText: function(evt) {
    evt.preventDefault();
    var text = this.ui.input.val();
    this.model.set('text', text);
  },

  clearText: function(evt) {
    evt.preventDefault();
    this.model.set('text', null);
  },
});
