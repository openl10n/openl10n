var Backbone = require('backbone');
var Project = require('./project');

module.exports = Backbone.Collection.extend({
  url: '/api/projects',
  model: Project,
  comparator: 'name'
})
