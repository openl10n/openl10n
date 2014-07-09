var $ = require('jquery');
var Marionette = require('backbone.marionette');
var msgbus = require('msgbus');

// All navigation that is relative should be passed through the navigate
// method, to be processed by the router. If the link has a `data-bypass`
// attribute, bypass the delegation completely.
function handleClickEvents() {
  var clickHandler = require('./helpers/click-handler');
  $('body').on('click', 'a[href]:not([data-bypass])', clickHandler);
}

// Aggregate the Marionette Behaviors
// See https://github.com/marionettejs/backbone.marionette/blob/master/docs/marionette.behaviors.md
function aggregateMarionetteBehaviors() {
  Marionette.Behaviors.behaviorsLookup = function() {
    return {
      Scrollable: require('./behaviors/scrollable')
    };
  }
}

// Initialize events bindings
function bindEvents() {
  require('./events/view-events');
}

// Custom ajax options
function initAjaxOptions() {
  $.ajaxPrefilter(function(options, originalOptions, jqXHR) {
    options.url = '/api' + options.url;
  });
}

module.exports = function(options) {
  initAjaxOptions();
  handleClickEvents();
  aggregateMarionetteBehaviors();
  bindEvents();
}
