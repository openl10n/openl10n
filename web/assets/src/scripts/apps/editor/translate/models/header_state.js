define(['underscore'], function(_) {

  return Backbone.Model.extend({
    defaults: {
      context: {},
      project: {},
      languages: [],
      resources: []
    },

    toJSON: function() {
      return {
        context: this.get('context').toJSON(),
        project: this.get('project').toJSON(),
        languages: this.get('languages').toJSON(),
        resources: []
      }
    }
  });

});
