define([
  'marionette',
  'tpl!bundle/editor/templates/stats',
], function(Marionette, statsTpl) {

  var StatsView = Marionette.ItemView.extend({
    template: statsTpl,
    tagName: 'ul',
    className: 'list-unstyled',

    ui: {
      all: 'a.filter-all',
      untranslated: 'a.filter-untranslated',
      unapproved: 'a.filter-unapproved',
    },

    events: {
      'click @ui.all': 'selectAll',
      'click @ui.untranslated': 'selectUntranslated',
      'click @ui.unapproved': 'selectUnapproved',
    },

    initialize: function(options) {
      this.translationsList = options.translationsList;
      this.filters = options.filters;

      this.listenTo(this.filters, 'change', this.render);
      this.listenTo(this.translationsList, 'sync', this.render);
      this.listenTo(this.translationsList, 'reset', this.render);
    },

    serializeData: function() {
      var currentFilter = '';
      if (null === this.filters.get('translated') && null === this.filters.get('approved')) {
        currentFilter = 'all';
      } else if ('0' === this.filters.get('translated') && null === this.filters.get('approved')) {
        currentFilter = 'untranslated';
      } else if ('1' === this.filters.get('translated') && '0' === this.filters.get('approved')) {
        currentFilter = 'unapproved';
      }

      // Stats of translationsList collection
      return {
        stats: this.translationsList.stats,
        filter: currentFilter,
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

  return StatsView;
});
