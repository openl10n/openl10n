var Backbone = require('backbone');

module.exports = Backbone.Model.extend({
  defaults: {
    approved: null,
    translated: null,
    text: null,
  },
});
