var $ = require('jquery');
var msgbus = require('msgbus');

var SiteView = require('../views/site-view');
var HeaderView = require('../views/header-view');


msgbus.reqres.setHandler('view:site', function() {
  var defer = $.Deferred();

  var siteView = new SiteView();
  siteView.render();
  siteView.headerRegion.show(new HeaderView());

  defer.resolve(siteView);

  return defer.promise();
})
