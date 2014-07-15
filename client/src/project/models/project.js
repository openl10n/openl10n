var Backbone = require('backbone');

module.exports = Backbone.Model.extend({
  idAttribute: 'slug',

  urlRoot: '/api/projects',

  defaults: {
    slug: '',
    name: '',
    default_locale: 'en',
    //description: '',
  }

})
