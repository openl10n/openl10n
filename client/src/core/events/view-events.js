var $ = require('jquery');
var layoutChannel = require('../../framework/radio').channel('layout');

var AppLayout = require('../views/app-layout');
var SiteView = require('../views/site-view');
var HeaderView = require('../views/header-view');

// Vars
var appLayout = null;
var siteView = null;
var headerView = null;

layoutChannel.reqres.setHandler('app-layout', function() {
  var defer = $.Deferred();

  if (null === appLayout || appLayout.isDestroyed) {
    appLayout = new AppLayout()
    appLayout.render();
  }

  defer.resolve(appLayout);

  return defer.promise();
})


layoutChannel.reqres.setHandler('site', function() {
  var defer = $.Deferred();

  if (null === siteView || siteView.isDestroyed) {
    siteView = new SiteView();
    headerView = new HeaderView();
  }

  var renderingAppLayout = layoutChannel.reqres.request('app-layout');

  $.when(renderingAppLayout).done(function(appLayout) {
    appLayout.bodyRegion.show(siteView);
    siteView.headerRegion.show(headerView);

    defer.resolve(siteView);
  });

  return defer.promise();
})
