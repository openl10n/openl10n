define(['marionette', 'string', 'editor/common/msgbus'], function(Marionette, S, msgBus) {

  var TranslationView = Marionette.ItemView.extend({
    template: '#ol-editor-translation-item-template',
    tagName: 'li',
    className: 'ol-editor-translation-list-item',

    initialize: function () {
      this.listenTo(this.model, 'change', this.render);
      this.listenTo(this.model, 'change:selected', this.adjustPosition);
    },

    templateHelpers: {
      S: S
    },

    events: {
      'click .item-wrapper': function(evt) {
        evt.preventDefault();
        this.model.set('selected', true);
      }
    },

    adjustPosition: function() {
      // Case where selected is false (but *was* true)
      if (!this.model.get('selected'))
        return;

      var $parent = this.$el.closest('.fullheight');

      var docViewTop = $parent.offset().top;
      var docViewBottom = docViewTop + $parent.height();

      var elemTop = this.$el.offset().top;
      var elemBottom = elemTop + this.$el.height();

      if (!(elemBottom <= docViewBottom && elemTop >= docViewTop)) {
        var scrollTop = elemTop - docViewTop + $parent.scrollTop() - $parent.height() / 2 + 100;

        $parent.animate({
          scrollTop: scrollTop
        }, 200);
      }
    }
  });

  return TranslationView;

});
