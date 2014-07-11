var Marionette = require('backbone.marionette');

module.exports = Marionette.ItemView.extend({
  template: require('../templates/stats'),
  tagName: 'ul',
  className: 'list-unstyled',

  ui: {
    'all': 'a.filter-all',
    'untranslated': 'a.filter-untranslated',
    'unapproved': 'a.filter-unapproved',
  },

  collectionEvents: {
    'sync': 'render',
    'reset': 'render',
  },

  modelEvents: {
    'change': 'render'
  },

  events: {
    'click @ui.all': 'selectAll',
    'click @ui.untranslated': 'selectUntranslated',
    'click @ui.unapproved': 'selectUnapproved',
  },

  initialize: function(options) {
    // Translation list
    this.collection = options.collection;

    // Filter bag
    this.model = options.model;
  },

  serializeData: function() {
    // Stats of translationsList collection
    return {
      stats: this.collection.stats,
      filter: {
        all: (null === this.model.get('translated') && null === this.model.get('approved')),
        untranslated: ('0' === this.model.get('translated') && null === this.model.get('approved')),
        unapproved: ('1' === this.model.get('translated') && '0' === this.model.get('approved'))
      }
    };
  },

  selectAll: function(evt) {
    evt.preventDefault();
    this.model.set({
      approved: null,
      translated: null,
    });
  },

  selectUntranslated: function(evt) {
    evt.preventDefault();
    this.model.set({
      approved: null,
      translated: '0',
    });
  },

  selectUnapproved: function(evt) {
    evt.preventDefault();
    this.model.set({
      approved: '0',
      translated: '1',
    });
  },
});
