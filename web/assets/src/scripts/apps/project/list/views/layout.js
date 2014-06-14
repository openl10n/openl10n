define([
  'marionette',
  'tpl!apps/project/list/templates/layout'
], function(Marionette, layoutTpl) {

  return Marionette.Layout.extend({
    template: layoutTpl,

    regions: {
      projectListRegion: '#project-list',
    }
  });

});
