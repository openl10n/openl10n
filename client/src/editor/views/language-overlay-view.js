var Marionette = require('backbone.marionette');

module.exports = Marionette.ItemView.extend({
  template: require('../templates/language-overlay'),
  className: 'x-editor--language-incentive-overlay',

  modelEvents: {
    'change': 'toggleHidden'
  },

  onRender: function() {
    this.toggleHidden();
  },

  toggleHidden: function() {
    if (this.model.get('source') && this.model.get('target')) {
      this.$el.addClass('hidden');
    } else {
      this.$el.removeClass('hidden');
    }
  }
});
