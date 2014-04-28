define(['backbone'], function(Backbone) {

  var Context = Backbone.Model.extend({
    defaults: {
      project: '',
      source_locale: '',
      target_locale: '',
    },
  });

  return Context;
});
