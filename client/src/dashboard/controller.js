var $ = require('jquery');
var Marionette = require('backbone.marionette');
var msgbus = require('msgbus');
//var µ = require('micro');

var DashboardView = require('./views/dashboard-view');
var ProjectListView = require('./views/project-list-view');

module.exports = Marionette.Controller.extend({
  index: function() {
    var siteViewRendering = msgbus.reqres.request('view:site');
    var projectListFetching = msgbus.reqres.request('model:projects');

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
