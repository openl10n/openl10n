define([
  'marionette',
  'tpl!bundle/editor/templates/stats',
], function(Marionette, statsTpl) {

  var StatsView = Marionette.ItemView.extend({
    template: statsTpl,
    tagName: 'ul',
    className: 'list-unstyled',

    initialize: function() {
      this.listenTo(this.collection, 'sync', this.render);
    },

    serializeData: function() {
      // Stats of translationsList collection
      return this.collection.stats;
    }
  });

  return StatsView;
});
