define([
  'marionette',
  'tpl!bundle/editor/templates/filters',
], function(Marionette, actionbarTpl) {

  var FiltersView = Marionette.ItemView.extend({
    template: actionbarTpl,
    tagName: 'span',

    ui: {
      'form': 'form',
      'input': 'input[type="text"]',
      'clear': '.clear',
    },

    modelEvents: {
      'change': 'render'
    },

    events: {
      'submit @ui.form': 'filterText',
      'click @ui.clear': 'clearText',
    },

    filterText: function(evt) {
      evt.preventDefault();
      var text = this.ui.input.val();
      this.model.set('text', text);
    },

    clearText: function(evt) {
      evt.preventDefault();
      this.model.set('text', null);
    },

  });

  return FiltersView;
});
