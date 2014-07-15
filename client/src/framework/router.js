var Marionette = require('backbone.marionette');
var _ = require('underscore');
var Radio = require('./radio');

var routerChannel = Radio.channel('router');

module.exports = Marionette.AppRouter.extend({
  constructor: function() {
    Marionette.AppRouter.apply(this, arguments);

    this.listenTo(this, 'route', this._onRoute);
    this.listenTo(routerChannel.vent, 'route', this._onGlobalRoute);
  },

  route: function(route, name, callback) {
    var router = this;

    var wrapped = function() {
      if (!router.started) {
        router.options.controller.start();
        router.started = true;
      }

      callback.apply(router, arguments);
    };

    Marionette.AppRouter.prototype.route.call(this, route, name, wrapped);
  },

  _onRoute: function() {
    routerChannel.vent.trigger('route', this);
  },

  _onGlobalRoute: function(router) {
    if (router !== this && this.started) {
      this.options.controller.stop();
      this.started = false;
    }
  }
});
