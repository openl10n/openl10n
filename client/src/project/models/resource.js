var Backbone = require('backbone');

module.exports = Backbone.Model.extend({
  urlRoot: '/resource',

  defaults: {
    pathname: '',
  }

})
