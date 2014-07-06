var $ = require('jquery');
var Backbone = require('backbone');
var Marionette = require('backbone.marionette');
var msgbus = require('msgbus');
var LanguageListView = require('./views/language-list-view');

module.exports = Marionette.Controller.extend({
  index: function(projectSlug) {
    var projectViewRendering = msgbus.reqres.request('view:project', projectSlug);
    var languagesFetching = msgbus.reqres.request('model:languages', projectSlug);

    $
      .when(projectViewRendering, languagesFetching)
      .done(function(projectView, languages) {
        var languageListView = new LanguageListView({collection: languages});

        projectView.languageListRegion.show(languageListView);
      });
  },

  edit: function() {
    console.log('Project edit');
  }
});
