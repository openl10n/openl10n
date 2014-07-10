var Backbone = require('backbone');
var Application = require('./framework/application');

// Application instance
var app = new Application();

// Initialize application modules
app.addInitializer(require('./core'));
app.addInitializer(require('./dashboard'));
app.addInitializer(require('./editor'));
app.addInitializer(require('./project'));

// Start history
app.on('start', function(options) {
  if (!Backbone.history.started) {
    Backbone.history.start({pushState: false});
  }
});

module.exports = app;
