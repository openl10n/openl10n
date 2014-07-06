var $ = require('jquery');

// Set Backbone jQuery's dependency
var Backbone = require('backbone');
Backbone.$ = $;

// After DOM is ready start the application
$(function() {
  require('./app').start();
})
