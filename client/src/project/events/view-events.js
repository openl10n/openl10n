var $ = require('jquery');
var layoutChannel = require('../../framework/radio').channel('layout');
var modelChannel = require('../../framework/radio').channel('model');
var ProjectLayoutView = require('../views/project-layout-view');
var ProjectSidebarView = require('../views/project-sidebar-view');

var projectLayoutView = null;
var projectLayoutSlug = null;

layoutChannel.reqres.setHandler('project', function(projectSlug) {
  var defer = $.Deferred();

  if (null !== projectLayoutView && !projectLayoutView.isDestroyed && projectLayoutSlug === projectSlug) {
    defer.resolve(projectLayoutView);
    return defer.promise();
  }

  var renderingSiteView = layoutChannel.reqres.request('site');
  var fetchingProject = modelChannel.reqres.request('project', projectSlug);

  $.when(renderingSiteView, fetchingProject).done(function(siteView, project) {
    projectLayoutView = new ProjectLayoutView();
    projectSidebarView = new ProjectSidebarView({model: project});
    projectLayoutSlug = projectSlug;

    siteView.mainRegion.show(projectLayoutView);
    projectLayoutView.sidebarRegion.show(projectSidebarView);

    defer.resolve(projectLayoutView);
  })

  return defer.promise();
})
