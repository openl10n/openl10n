define([
  'underscore',
  'marionette',
  'editor/translate/views/translation-item'
], function(_, Marionette, TranslationView) {

  var TranslationListView = Marionette.CollectionView.extend({
    itemView: TranslationView,
    tagName: 'ul',
    className: 'list-unstyled',

    initialize: function() {
      var _this = this;

      $(document).on('keydown', this.keydown.bind(this));
    },

    // override remove to also unbind events
    remove: function() {
      $(document).off('keydown', this.keydown.bind(this));

      Backbone.View.prototype.remove.call(this);
    },

    keydown: function(evt) {
      if (window.event) {
        key = window.event.keyCode;
        isShift = window.event.shiftKey;
      } else {
        key = evt.which;
        isShift = evt.shiftKey;
      }

      // If pressed TAB key
      if (key === 9) {
        evt.preventDefault();

        if (isShift)
          this.collection.selectPreviousItem();
        else
          this.collection.selectNextItem();
      }

      return;

      if (!isShift) {
        switch (key) {
          case 16:
            // ignore shift key
            break;
          case 9:
            evt.preventDefault();
            this.collection.selectPreviousItem();
            break;
          case 40:
            evt.preventDefault();
            this.collection.selectNextItem();
            break;
        }
      }
    },
  });

  return TranslationListView;
})
