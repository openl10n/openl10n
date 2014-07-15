var $ = require('jquery');
var Backbone = require('backbone');
var Controller = require('../framework/controller');

var layoutChannel = require('../framework/radio').channel('layout');
var modelChannel = require('../framework/radio').channel('model');
var Project = require('./models/project');

var IndexView = require('./views/index-view');
var LanguageListView = require('./views/language-list-view');
var ResourceListView = require('./views/resource-list-view');
var CreateProjectView = require('./views/create-project-view');
var ProjectFormView = require('./views/project-form-view');

module.exports = Controller.extend({
  channelName: 'project',

  index: function(projectSlug) {
    var projectViewRendering = layoutChannel.reqres.request('project', projectSlug);
    var languagesFetching = modelChannel.reqres.request('languages', projectSlug);
    var resourcesFetching = modelChannel.reqres.request('resources', projectSlug);

    $
      .when(projectViewRendering, languagesFetching, resourcesFetching)
      .done(function(projectView, languages, resources) {
        modelChannel.vent.trigger('menu:project:select', 'resources')

        var indexView = new IndexView();
        var languageListView = new LanguageListView({collection: languages});
        var resourceListView = new ResourceListView({collection: resources});

        projectView.contentRegion.show(indexView);
        indexView.languageListRegion.show(languageListView);
        indexView.resourceListRegion.show(resourceListView);
      });
  },

  new: function() {
    var siteViewRendering = layoutChannel.reqres.request('site');

    $
      .when(siteViewRendering)
      .done(function(siteView) {
        var project = new Project();
        var createProjectView = new CreateProjectView();
        var projectFormView = new ProjectFormView({model: project});

        siteView.mainRegion.show(createProjectView);
        createProjectView.projectFormRegion.show(projectFormView);
      });
  },

  edit: function() {
    console.log('Project edit');
  }
});
