var Backbone = require('backbone');
var BackboneCycle = require('backbone.cycle');

module.exports = Backbone.Model.extend({
  urlRoot: function() {
    return '/api/translations/' + this.id + '/phrases/' + this.locale;
  },

  defaults: {
    text: '',
    approved: false
  }
})
