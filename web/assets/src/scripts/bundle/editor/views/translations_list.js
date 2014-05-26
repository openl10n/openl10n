define([
  'underscore',
  'marionette',
  'bundle/editor/views/translation_item',
  'bundle/editor/views/translations_empty',
  'tpl!bundle/editor/templates/translations_list',
], function(_, Marionette, TranslationView, TranslationsEmptyView, translationsListTpl) {

  var TranslationListView = Marionette.CompositeView.extend({
    template: translationsListTpl,
    itemView: TranslationView,
    emptyView: TranslationsEmptyView,
    itemViewContainer: 'ul',
    className: 'x-editor--translations-list',

    collectionEvents: {
      'request': 'loading',
      'sync': 'render',
    },

    initialize: function() {
      var _this = this;

      // _.bindAll(this, 'keydown');
      // $(document).on('keydown', this.keydown);

      // msgBus.events.on('translations:select-next', function() {
      //   _this.collection.selectNextItem();
      // });
    },

    // Display a loading animation
    loading: function(target) {
      // Ensure the request event comes from collection and not one of its models
      // (because of event bubbling)
      if (target && target !== this.collection) {
        return;
      }

      this.$el.addClass('loading');
    },

    // Overwrite render method to stop loading animation
    render: function(target) {
      if (target && target !== this.collection) {
        return;
      }

      this.$el.removeClass('loading');
      Marionette.CompositeView.prototype.render.call(this);
      return this;
    },

    // Scrollable behaviour
    onRender: function() {
      var _this = this;

      var $window = $(window);
      var $el = this.$el.find('.js-scrollable');
      var updateBlockHeight = function UpdateBlockHeight() {
        $el.each(function() {
          var $this = $(this);
          var height = $window.height() - $(this).offset().top;
          $(this).height(height);
        });
      }

      setTimeout(updateBlockHeight, 200); // hack
      $(window).resize(updateBlockHeight);
    },

    // override remove to also unbind events
    // remove: function() {
    //   $(document).off('keydown', this.keydown);

    //   Backbone.View.prototype.remove.call(this);
    // },

    // keydown: function(evt) {
    //   if (window.event) {
    //     key = window.event.keyCode;
    //     isShift = window.event.shiftKey;
    //     isCtrl = window.event.ctrlKey;
    //   } else {
    //     key = evt.which;
    //     isShift = evt.shiftKey;
    //     isCtrl = evt.ctrlKey;
    //   }

    //   // If pressed TAB key
    //   if (key === 9) {
    //     evt.preventDefault();

    //     var translation = this.collection.selectedItem;
    //     if (null !== translation && translation.get('is_dirty'))
    //       translation.save({is_translated: true});

    //     if (isShift)
    //       this.collection.selectPreviousItem();
    //     else
    //       this.collection.selectNextItem();
    //   }

    //   // If pressed ENTER key
    //   if (key === 13 && isCtrl) {
    //     evt.preventDefault();

    //     var translation = this.collection.selectedItem;
    //     if (null === translation)
    //       return;

    //     if (isShift)
    //       translation.save({
    //         is_translated: true,
    //         is_approved: true
    //       });
    //     else
    //       translation.save({
    //         is_translated: true,
    //       });

    //     this.collection.selectNextItem();
    //   }
    // },
  });

  return TranslationListView;
})
