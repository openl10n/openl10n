var Controller = require('./controller');
var Router = require('./router');

module.exports = function(options) {
  var controller = new Controller();
  var router = new Router({controller: controller});
}
