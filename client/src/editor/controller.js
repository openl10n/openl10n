var $ = require('jquery');

var Controller = require('../framework/controller');
var EditorLayoutView = require('./views/editor-layout-view');
var TranslationListView = require('./views/translation-list-view');
var LocaleChooserView = require('./views/locale-chooser-view');
var Context = require('./models/context');

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
    var context = new Context({source: source, target: target});

    var projectViewRendering = layoutChannel.reqres.request('project', projectSlug);
    var resourcesFetching = modelChannel.reqres.request('resources', projectSlug);
    var languagesFetching = modelChannel.reqres.request('languages', projectSlug);

    $
      .when(projectViewRendering, languagesFetching)
      .done(function(projectView, languages) {
        // layoutChannel.vent.trigger('project:menu', 'translate');

        // Layout
        var editorView = new EditorLayoutView();
        projectView.contentRegion.show(editorView);

        // Languages chooser
        var sourceLocaleChooserView = new LocaleChooserView({
          collection: languages,
          model: context,
          modelAttribute: 'source'
        });
        var targetLocaleChooserView = new LocaleChooserView({
          collection: languages,
          model: context,
          modelAttribute: 'target'
        });
        editorView.sourceChooserRegion.show(sourceLocaleChooserView);
        editorView.targetChooserRegion.show(targetLocaleChooserView);

        // Translation list
        var translationListView = new TranslationListView();
        editorView.translationsListRegion.show(translationListView);
      });
  }
});
