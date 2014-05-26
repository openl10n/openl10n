define([
  'marionette',
  'string',
  'tpl!bundle/editor/templates/translation_item',
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

    modelEvents: {
      'selected': 'onSelect',
      'deselected': 'onDeselect',
    },

    onRender: function() {
      if (this.model.selected)
        this.$el.addClass('active');
    },

    onSelect: function() {
      this.$el.addClass('active');
    },

    onDeselect: function() {
      this.$el.removeClass('active');
    },

    selectTranslation: function() {
      this.model.select();
    },

  });

});
