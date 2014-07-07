var $ = require('jquery');
var Backbone = require('backbone');

module.exports = function(evt) {
  var $this = $(this);

  // Get the absolute anchor href.
  // this.router.previousRoute = location.href;
  var href = {
    prop: $this.prop('href'),
    attr: $this.attr('href')
  };

  // Get the absolute root.
  var root = location.protocol + '//' + location.host;

  // Ensure the root is part of the anchor href, meaning it's relative.
  if (href.prop.slice(0, root.length) === root) {
    // Stop the default event to ensure the link will not cause a page
    // refresh.
    evt.preventDefault();
    // `Backbone.history.navigate` is sufficient for all Routers and will
    // trigger the correct events. The Router's internal `navigate` method
    // calls this anyways.  The fragment is sliced from the root.
    Backbone.history.navigate(href.attr, true);
  }
};
