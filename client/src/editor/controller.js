var $ = require('jquery');

var Controller = require('../framework/controller');
var EditorLayoutView = require('./views/editor-layout-view');
var TranslationListView = require('./views/translation-list-view');

var layoutChannel = require('../framework/radio').channel('layout');
var modelChannel = require('../framework/radio').channel('model');

module.exports = Controller.extend({
  channelName: 'editor',

  start: function() {
  },

  stop: function() {
    this.stopListening();
  },

  translate: function(projectSlug, source, target, translationId, filters) {
    this._initEditor(projectSlug, source, target, translationId, filters);
  },

  proofread: function(projectSlug, source, target, translationId, filters) {
    this._initEditor(projectSlug, source, target, translationId, filters);
  },

  _initEditor: function(projectSlug, source, target, translationId, filters) {
    var projectViewRendering = layoutChannel.reqres.request('project', projectSlug);
    var resourcesFetching = modelChannel.reqres.request('resources', projectSlug);
    var languagesFetching = modelChannel.reqres.request('languages', projectSlug);

    $
      .when(projectViewRendering)
      .done(function(projectView) {
        // layoutChannel.vent.trigger('project:menu', 'translate');

        var editorView = new EditorLayoutView();
        projectView.contentRegion.show(editorView);

        var translationListView = new TranslationListView();
        editorView.translationsListRegion.show(translationListView);
      });
  }
});
