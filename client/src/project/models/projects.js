var Backbone = require('backbone');
var Project = require('./project');

module.exports = Backbone.Collection.extend({
  url: '/projects',
  model: Project,
  comparator: 'name'
})
