define(['backbone'], function(Backbone) {

  var FilterBag = Backbone.Model.extend({
    defaults: {
      domain: null,
      resource: null,
      text: '',
      approved: null,
      translated: null
    },
  });

  return FilterBag;
});
