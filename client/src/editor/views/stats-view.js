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
    this.model = options.filters;
  },

  serializeData: function() {
    // var currentFilter = '';
    // if (null === this.filters.get('translated') && null === this.filters.get('approved')) {
    //   currentFilter = 'all';
    // } else if ('0' === this.filters.get('translated') && null === this.filters.get('approved')) {
    //   currentFilter = 'untranslated';
    // } else if ('1' === this.filters.get('translated') && '0' === this.filters.get('approved')) {
    //   currentFilter = 'unapproved';
    // }

    // Stats of translationsList collection
    return {
      stats: this.collection.stats,
    };
  },

  selectAll: function(evt) {
    evt.preventDefault();
    this.filters.set({
      approved: null,
      translated: null,
    });
  },

  selectUntranslated: function(evt) {
    evt.preventDefault();
    this.filters.set({
      approved: null,
      translated: '0',
    });
  },

  selectUnapproved: function(evt) {
    evt.preventDefault();
    this.filters.set({
      approved: '0',
      translated: '1',
    });
  },
});
