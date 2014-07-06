var Wreqr = require('backbone.wreqr');
var AppLayout = require('./micro/views/app-layout');

module.exports = {
  reqres: new Wreqr.RequestResponse(),
  commands: new Wreqr.Commands(),
  events: new Wreqr.EventAggregator(),
  layout: new AppLayout(),

  init: function() {
    this.layout.render();
  }
};
