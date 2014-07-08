var $ = require('jquery');
var Backbone = require('backbone');
var Marionette = require('backbone.marionette');
var msgbus = require('msgbus');

var IndexView = require('./views/index-view');
var LanguageListView = require('./views/language-list-view');
var ResourceListView = require('./views/resource-list-view');

module.exports = Marionette.Controller.extend({
  index: function(projectSlug) {
    var projectViewRendering = msgbus.reqres.request('view:project', projectSlug);
    var languagesFetching = msgbus.reqres.request('model:languages', projectSlug);
    var resourcesFetching = msgbus.reqres.request('model:resources', projectSlug);

    $
      .when(projectViewRendering, languagesFetching, resourcesFetching)
      .done(function(projectView, languages, resources) {
        var indexView = new IndexView();
        var languageListView = new LanguageListView({collection: languages});
        var resourceListView = new ResourceListView({collection: resources});

        projectView.contentRegion.show(indexView);
        indexView.languageListRegion.show(languageListView);
        indexView.resourceListRegion.show(resourceListView);
      });
  },

  edit: function() {
    console.log('Project edit');
  }
});
