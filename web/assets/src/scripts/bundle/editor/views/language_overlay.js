define([
  'marionette',
  'tpl!bundle/editor/templates/language_overlay'
], function(Marionette, languageOverlayTpl) {

  return Marionette.ItemView.extend({
    template: languageOverlayTpl,
    className: 'x-editor--language-incentive-overlay',

    modelEvents: {
      'change': 'toggleHidden'
    },

    toggleHidden: function() {
      if (this.model.get('source') && this.model.get('target')) {
        this.$el.addClass('hidden');
      } else {
        this.$el.removeClass('hidden');
      }
    }

  });

});
