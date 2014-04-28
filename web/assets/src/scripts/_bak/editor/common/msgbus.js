// msgbus decoupled from app
define(['backbone.wreqr'], function(Wreqr) {
  return {
    reqres: new Wreqr.RequestResponse(),
    commands: new Wreqr.Commands(),
    events: new Wreqr.EventAggregator()
  }
});
