define(['marionette'], function(Marionette) {

  var FiltersView = Marionette.ItemView.extend({
    template: '#ol-editor-translation-list-filters',

    ui: {
      filterClear: '.filter-clear',
      filterTranslated: '.filter-translated',
      filterReviewed: '.filter-reviewed',
    },

    initialize: function () {
      // this.listenTo(Editor.context, 'change:domain', this.render);
      // this.listenTo(Editor.context, 'change:source', this.render);
      // this.listenTo(Editor.context, 'change:target', this.render);
    },

    onRender: function() {
      var _this = this;

      this.ui.filterClear.on('click', function(evt) {
        evt.preventDefault();
        _this.model.set({
          'translated': null,
          'approved': null,
        });
      })

      this.ui.filterTranslated.on('click', function(evt) {
        evt.preventDefault();
        _this.model.set({
          'translated': '0',
          'approved': null,
        });
      })

      this.ui.filterReviewed.on('click', function(evt) {
        evt.preventDefault();
        _this.model.set({
          'translated': '1',
          'approved': '0',
        });
      })
    }

  });

  return FiltersView;
});
