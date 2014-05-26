define([
  'underscore',
  'marionette',
  'tpl!bundle/editor/templates/translations_empty',
], function(_, Marionette, translationsEmptyTpl) {

  return Marionette.ItemView.extend({
    template: translationsEmptyTpl
  });
})
