;(function(win, doc, Editor) {

  Editor.Views.TranslationView = Backbone.Marionette.ItemView.extend({
    template: '#ol-editor-translation-item-template',
    tagName: 'li',
    className: 'ol-editor-translation-list-item',

    initialize: function () {
      this.listenTo(this.model, 'change', this.render);
      this.listenTo(this.model, 'change:selected', this.adjustPosition);
    },

    events: {
      'click a': function(evt) {
        evt.preventDefault();
        Editor.context.set('hash', this.model.id);
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

})(window, window.document, window.Editor)
