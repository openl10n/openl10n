define(['backbone'], function(Backbone) {

  var Context = Backbone.Model.extend({
    defaults: {
      source: '',
      target: '',
    },
  });

  return Context;
});
