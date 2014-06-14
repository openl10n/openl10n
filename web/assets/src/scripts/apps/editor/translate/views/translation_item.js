define([
  'marionette',
  'string',
  'tpl!apps/editor/translate/templates/translation_item',
], function(Marionette, S, translationItemTpl) {

  return Marionette.ItemView.extend({
    template: translationItemTpl,
    tagName: "li",
    className: "translations-item",

    modelEvents: {
      'change': 'render',
      'selected': 'render',
      'deselected': 'render'
    },

    templateHelpers: {
      S: S
    },

    events: {
      'click': 'selectTranslation'
    },

    selectTranslation: function() {
      this.model.select();
    },

    serializeData: function() {
      var attributes = this.model.toJSON();
      attributes.selected = this.model.selected;

      return attributes;
    }

  });

});
