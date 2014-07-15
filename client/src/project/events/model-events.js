var $ = require('jquery');
var modelChannel = require('../../framework/radio').channel('model');

var Project = require('../models/project');
var ProjectCollection = require('../models/projects');
var LanguageCollection = require('../models/languages');
var ResourceCollection = require('../models/resources');

modelChannel.reqres.setHandler('projects', function() {
  var projects = new ProjectCollection();
  var defer = $.Deferred();

  projects.fetch({
    success: function(data) {
      defer.resolve(data);
    }
  });

  return defer.promise();
});

modelChannel.reqres.setHandler('project', function(projectSlug) {
  var project = new Project({slug: projectSlug});
  var defer = $.Deferred();

  project.fetch({
    success: function(data) {
      defer.resolve(data);
    },
    error: function(data) {
      defer.reject();
    }
  });

  return defer.promise();
});

modelChannel.reqres.setHandler('languages', function(projectSlug) {
  var languages = new LanguageCollection([], {projectSlug: projectSlug});
  var defer = $.Deferred();

  languages.fetch({
    success: function(data) {
      defer.resolve(data);
    }
  });

  return defer.promise();
});

modelChannel.reqres.setHandler('resources', function(projectSlug) {
  var resources = new ResourceCollection([], {projectSlug: projectSlug});
  var defer = $.Deferred();

  resources.fetch({
    success: function(data) {
      defer.resolve(data);
    },
    fail: function() {
      defer.reject();
    }
  });

  return defer.promise();
});
