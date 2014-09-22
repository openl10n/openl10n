var $ = require('jquery');
var _ = require('underscore');

var Backbone = require('backbone');
var Marionette = require('backbone.marionette');

var TranslationPhrase = require('../models/translation-phrase');
var TranslationItemView = require('./translation-item-view');
var TranslationEmptyView = require('./translation-empty-view');

module.exports = Marionette.CompositeView.extend({
  template: require('../templates/translation-list'),
  childView: TranslationItemView,
  emptyView: TranslationEmptyView,
  childViewContainer: 'ul',
  className: 'x-editor--translations-list',

  collectionEvents: {
    'select:one': 'adjustPosition',
    'request': 'loading',
    'sync': 'render',
  },

  initialize: function() {
    _.bindAll(this, 'onKeydown');
    $(document).on('keydown', this.onKeydown);
  },

  // override remove to also unbind events
  remove: function() {
    $(document).off('keydown', this.onKeydown);

    Backbone.View.prototype.remove.call(this);
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
    var $window = $(window);
    var $el = this.$el.find('.js-scrollable');
    var updateBlockHeight = function UpdateBlockHeight() {
      $el.each(function() {
        var $this = $(this);
        var height = $window.height() - $this.offset().top;
        $this.height(height);
      });
    }

    setTimeout(function() { updateBlockHeight(); }, 200);
    $window.resize(updateBlockHeight);
  },

  onKeydown: function(evt) {
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

      if (isShift)
        this.collection.selectPrevNoLoop();
      else
        this.collection.selectNextNoLoop();
    }

    // If pressed ENTER key
    if (key === 13 && isCtrl) {
      evt.preventDefault();

      if (!this.collection.selected)
        return;

      var translation = new TranslationPhrase({
        text: this.collection.selected.get('target_phrase'),
        approved: false
      });

      if ('' === translation.get('text')) {
        alert('Unable to save an empty string');
        return;
      }

      translation.id = this.collection.selected.id;
      translation.locale = this.collection.selected.get('target_locale');

      if (isShift) {
        translation.set('approved', true);
      }

      this.collection.selected.set({
        'is_translated': true,
        'is_approved': translation.get('approved'),
        'edited': false,
      });

      translation.save().fail(function() {
        alert('Unable to save translation, please reload the page');
      });
    }
  },

  adjustPosition: function() {
    var selectedTranslation = this.collection.selected;
    if (!selectedTranslation)
      return;

    var $translationList = this.$el.find('.js-scrollable');
    var $selectedTranslation = this.children.findByModel(selectedTranslation).$el;

    var docViewTop = $translationList.offset().top;
    var docViewBottom = docViewTop + $translationList.height();

    var elemTop = $selectedTranslation.offset().top;
    var elemBottom = elemTop + $selectedTranslation.height();

    if (!(elemBottom <= docViewBottom && elemTop >= docViewTop)) {
      var scrollTop = elemTop - docViewTop + $translationList.scrollTop() - $translationList.height() / 2 + 100;

      $translationList.animate({
        scrollTop: scrollTop
      }, 200);
    }
  }
});
