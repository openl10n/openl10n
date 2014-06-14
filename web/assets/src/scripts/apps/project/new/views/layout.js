define([
  'marionette',
  'tpl!apps/project/new/templates/layout'
], function(Marionette, layoutTpl) {

  return Marionette.Layout.extend({
    template: layoutTpl,

    regions: {
      projectFormRegion: '#project-form'
    }
  });
});
