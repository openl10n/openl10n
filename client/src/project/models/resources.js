var Backbone = require('backbone');
var Resource = require('./resource');

module.exports = Backbone.Collection.extend({
  url: function() {
    return '/resources?project=' + this.projectSlug
  },
  model: Resource,
  comparator: 'pathname',

  initialize: function(models, options) {
    options = options || {};
    this.projectSlug = options.projectSlug;
  },
})
