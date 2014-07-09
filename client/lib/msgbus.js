var Wreqr = require('backbone.wreqr');

module.exports = {
  reqres: new Wreqr.RequestResponse(),
  commands: new Wreqr.Commands(),
  vent: new Wreqr.EventAggregator()
};
