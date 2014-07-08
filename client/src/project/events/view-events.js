var $ = require('jquery');
var msgbus = require('msgbus');
var ProjectLayoutView = require('../views/project-layout-view');
var ProjectSidebarView = require('../views/project-sidebar-view');

var projectLayoutView = null;
var projectLayoutSlug = null;

msgbus.reqres.setHandler('view:project', function(projectSlug) {
  var defer = $.Deferred();

  var renderingSiteView = msgbus.reqres.request('view:site');
  var fetchingProject = msgbus.reqres.request('model:project', projectSlug);

  $.when(renderingSiteView, fetchingProject).done(function(siteView, project) {
    if (null === projectLayoutView || projectLayoutView.isDestroyed || projectLayoutSlug !== projectSlug) {
      projectLayoutView = new ProjectLayoutView();
      projectSidebarView = new ProjectSidebarView({model: project});
      projectLayoutSlug = projectSlug;
    }

    siteView.mainRegion.show(projectLayoutView);
    projectLayoutView.sidebarRegion.show(projectSidebarView);

    defer.resolve(projectLayoutView);
  })

  return defer.promise();
})
