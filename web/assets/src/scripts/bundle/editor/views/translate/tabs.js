define([
  'marionette',
  'tpl!bundle/editor/templates/translate/tabs',
], function(Marionette, tabsTpl) {

  var TabsView = Marionette.ItemView.extend({
    template: tabsTpl,
  });

  return TabsView;
});
