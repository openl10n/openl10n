var $ = require('jquery');
var Marionette = require('backbone.marionette');
var msgbus = require('msgbus');

var EditorLayoutView = require('./views/editor-layout-view');
var TranslationListView = require('./views/translation-list-view');

module.exports = Marionette.Controller.extend({
  translate: function(projectSlug, source, target, translationId, filters) {
    var projectViewRendering = msgbus.reqres.request('view:project', projectSlug);

    $
      .when(projectViewRendering)
      .done(function(projectView) {
        msgbus.vent.trigger('menu:project:select', 'translate');

        var editorView = new EditorLayoutView();
        var translationListView = new TranslationListView();

        projectView.contentRegion.show(editorView);
        editorView.translationsListRegion.show(translationListView);
      });
  },

  proofread: function(projectSlug, source, target, translationId, filters) {
    console.log('Proofread ' + projectSlug);
  }
});
