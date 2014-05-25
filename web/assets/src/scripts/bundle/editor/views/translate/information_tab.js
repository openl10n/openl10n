define([
  'marionette',
  'tpl!bundle/editor/templates/translate/information_tab',
], function(Marionette, informationTabTpl) {

  var InformationTabView = Marionette.ItemView.extend({
    template: informationTabTpl,
  });

  return InformationTabView;
});
