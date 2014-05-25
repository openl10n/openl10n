define([
  'marionette',
  'tpl!bundle/editor/templates/filters',
], function(Marionette, actionbarTpl) {

  var FiltersView = Marionette.ItemView.extend({
    template: actionbarTpl,
    tagName: 'span'
  });

  return FiltersView;
});
