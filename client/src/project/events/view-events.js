var $ = require('jquery');
var msgbus = require('msgbus');
var ProjectLayoutView = require('../views/project-layout-view');
var ProjectSidebarView = require('../views/project-sidebar-view');

msgbus.reqres.setHandler('view:project', function(projectSlug) {
  var defer = $.Deferred();

  var renderingSiteView = msgbus.reqres.request('view:site');
  var fetchingProject = msgbus.reqres.request('model:project', projectSlug);

  $.when(renderingSiteView, fetchingProject).done(function(siteView, project) {
    var projectLayoutView = new ProjectLayoutView();
    var projectSidebarView = new ProjectSidebarView({model: project});

    siteView.mainRegion.show(projectLayoutView);
    projectLayoutView.sidebarRegion.show(projectSidebarView);

    defer.resolve(projectLayoutView);
  })

  return defer.promise();
})
