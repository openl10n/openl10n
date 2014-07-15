var Marionette = require('backbone.marionette');
var LanguageItemView = require('./language-item-view');

module.exports = Marionette.CompositeView.extend({
  childView: LanguageItemView,
  template: require('../templates/language-list'),
  childViewContainer: 'ul',

  serializeData: function() {
    return {
      count: this.collection.length,
    }
  }
});
