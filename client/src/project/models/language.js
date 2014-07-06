var Backbone = require('backbone');

module.exports = Backbone.Model.extend({
  idAttribute: 'locale',

  urlRoot: function() {
    return '/api/projects/' + this.projectSlug + '/languages'
  },

  defaults: {
    name: '',
    locale: '',
  },

  initialize: function(options) {
    options = options || {};
    this.projectSlug = options.projectSlug;
  },
});
