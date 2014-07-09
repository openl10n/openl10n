var Backbone = require('backbone');
var Language = require('./language');

module.exports = Backbone.Collection.extend({
  url: function() {
    return '/api/projects/' + this.projectSlug + '/languages'
  },

  initialize: function(models, options) {
    options = options || {};
    this.projectSlug = options.projectSlug;
  },

  model: Language,
  comparator: 'name'
});
