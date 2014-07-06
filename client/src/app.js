var _ = require('underscore');
var Backbone = require('backbone');
var Marionette = require('backbone.marionette');

// Application instance
var app = new Marionette.Application();

// Initialize application modules
app.addInitializer(require('./core'));
app.addInitializer(require('./dashboard'));
app.addInitializer(require('./editor'));
app.addInitializer(require('./project'));

// Start history
app.addInitializer(function(options) {
  if (!Backbone.history.started) {
    Backbone.history.start({pushState: false});
  }
});

module.exports = app;
