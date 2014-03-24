define([
  'underscore',
  'marionette',
  'editor/translate/views/translation-item',
  'editor/common/msgbus'
], function(_, Marionette, TranslationView, msgBus) {

  var TranslationListView = Marionette.CollectionView.extend({
    itemView: TranslationView,
    tagName: 'ul',
    className: 'list-unstyled',

    initialize: function() {
      var _this = this;

      _.bindAll(this, 'keydown');
      $(document).on('keydown', this.keydown);

      msgBus.events.on('translations:select-next', function() {
        _this.collection.selectNextItem();
      });
    },

    // override remove to also unbind events
    remove: function() {
      $(document).off('keydown', this.keydown);

      Backbone.View.prototype.remove.call(this);
    },

    keydown: function(evt) {
      if (window.event) {
        key = window.event.keyCode;
        isShift = window.event.shiftKey;
        isCtrl = window.event.ctrlKey;
      } else {
        key = evt.which;
        isShift = evt.shiftKey;
        isCtrl = evt.ctrlKey;
      }

      // If pressed TAB key
      if (key === 9) {
        evt.preventDefault();

        var translation = this.collection.selectedItem;
        if (null !== translation && translation.get('is_dirty'))
          translation.save({is_translated: true});

        if (isShift)
          this.collection.selectPreviousItem();
        else
          this.collection.selectNextItem();
      }

      // If pressed ENTER key
      if (key === 13 && isCtrl) {
        evt.preventDefault();

        var translation = this.collection.selectedItem;
        if (null === translation)
          return;

        if (isShift)
          translation.save({
            is_translated: true,
            is_approved: true
          });
        else
          translation.save({
            is_translated: true,
          });

        this.collection.selectNextItem();
      }
    },
  });

  return TranslationListView;
})
