var $ = require('jquery');
var Controller = require('../framework/controller');
var layoutChannel = require('../framework/radio').channel('layout');
var modelChannel = require('../framework/radio').channel('model');

var DashboardView = require('./views/dashboard-view');
var ProjectListView = require('./views/project-list-view');

module.exports = Controller.extend({
  channelName: 'dashboard',

  index: function() {
    var siteViewRendering = layoutChannel.reqres.request('site');
    var projectListFetching = modelChannel.reqres.request('projects');

    $
      .when(siteViewRendering, projectListFetching)
      .done(function(siteView, projects) {
        var dashboardView = new DashboardView();
        var projectListView = new ProjectListView({collection: projects});

        siteView.mainRegion.show(dashboardView);
        dashboardView.projectListRegion.show(projectListView);
      });
  }
});
