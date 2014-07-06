var Wreqr = require('backbone.wreqr');

module.exports = {
  reqres: new Wreqr.RequestResponse(),
  commands: new Wreqr.Commands(),
  events: new Wreqr.EventAggregator()
};
