define(['backbone'], function(Backbone) {

  var FilterBag = Backbone.Model.extend({
    defaults: {
      approved: null,
      translated: null,
      text: null,
    },
  });

  return FilterBag;
});
