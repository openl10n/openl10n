var $ = require('jquery');
var msgbus = require('msgbus');

var ProjectCollection = require('../models/projects');
var Project = require('../models/project');
var LanguageCollection = require('../models/languages');

msgbus.reqres.setHandler('model:projects', function() {
  var projects = new ProjectCollection();
  var defer = $.Deferred();

  projects.fetch({
    success: function(data) {
      defer.resolve(data);
    }
  });

  return defer.promise();
});

msgbus.reqres.setHandler('model:project', function(projectSlug) {
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

msgbus.reqres.setHandler('model:languages', function(projectSlug) {
  var languages = new LanguageCollection([], {projectSlug: projectSlug});
  var defer = $.Deferred();

  languages.fetch({
    success: function(data) {
      defer.resolve(data);
    }
  });

  return defer.promise();
});
