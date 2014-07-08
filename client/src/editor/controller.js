var $ = require('jquery');
var Marionette = require('backbone.marionette');
var msgbus = require('msgbus');

var EditorLayoutView = require('./views/editor-layout-view');

module.exports = Marionette.Controller.extend({
  translate: function(projectSlug, source, target, translationId, filters) {
    var projectViewRendering = msgbus.reqres.request('view:project', projectSlug);

    $
      .when(projectViewRendering)
      .done(function(projectView, languages, resources) {
        var editorView = new EditorLayoutView();

        projectView.contentRegion.show(editorView);
      });
  },

  proofread: function(projectSlug, source, target, translationId, filters) {
    console.log('Proofread ' + projectSlug);
  }
});
