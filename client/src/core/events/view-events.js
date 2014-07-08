var $ = require('jquery');
var msgbus = require('msgbus');

var AppLayout = require('../views/app-layout');
var SiteView = require('../views/site-view');
var HeaderView = require('../views/header-view');

// Vars
var appLayout = null;
var siteView = null;
var headerView = null;

msgbus.reqres.setHandler('view:app-layout', function() {
  var defer = $.Deferred();

  if (null === appLayout || appLayout.isDestroyed) {
    appLayout = new AppLayout()
    appLayout.render();
  }

  defer.resolve(appLayout);

  return defer.promise();
})


msgbus.reqres.setHandler('view:site', function() {
  var defer = $.Deferred();

  if (null === siteView || siteView.isDestroyed) {
    siteView = new SiteView();
    headerView = new HeaderView();
  }

  var renderingAppLayout = msgbus.reqres.request('view:app-layout');

  $.when(renderingAppLayout).done(function(appLayout) {
    appLayout.bodyRegion.show(siteView);
    siteView.headerRegion.show(headerView);

    defer.resolve(siteView);
  });

  return defer.promise();
})
