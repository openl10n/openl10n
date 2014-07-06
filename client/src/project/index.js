var $ = require('jquery');
var msgbus = require('msgbus');
var Controller = require('./controller');
var Router = require('./router');

// Init event binding
require('./events/model-events');
require('./events/view-events');

module.exports = function(options) {
  var controller = new Controller();
  var router = new Router({controller: controller});
}
