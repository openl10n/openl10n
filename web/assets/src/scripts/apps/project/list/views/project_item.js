define([
  'marionette',
  'app',
  'tpl!apps/project/list/templates/project_item'
], function(Marionette, app, itemTpl) {

  return Marionette.ItemView.extend({
    template: itemTpl,

    events: {
      'click': 'showProject'
    },

    showProject: function() {
      app.trigger('project:show', this.model.id);
    }
  });

});
