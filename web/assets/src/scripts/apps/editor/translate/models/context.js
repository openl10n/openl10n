define(['app'], function(app) {

  return Backbone.Model.extend({
    defaults: {
      // Models (project slug + translation id)
      project: null,
      //translation: null,

      // Locales
      source: null,
      target: null,

      // Filters
      resource: null,
      text: null,
    },

    initialize: function() {
      var _this = this;

      app.on('editor:source', function(source) {
        console.log('update source');
        _this.set('source', source);
      });

      app.on('editor:target', function(target) {
        console.log('update target');
        _this.set('target', target);
      });
    }
  });

});
