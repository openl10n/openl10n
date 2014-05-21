define([
  'app',
  'apps/editor/translate/models',
  'apps/editor/translate/views',
  'entities/translation_commit/collection',
  'entities/project/model',
  'entities/language'
], function(app, Model, View, TranslationCommitCollection) {

  var context;
  var layout;
  var translations;

  function initApp() {
    var projectSlug = context.get('project');
    if (!projectSlug) {
      // Meh!
      return;
    }

    var renderingLayout = app.request('layout:project', projectSlug);
    $.when(renderingLayout).done(function(projectLayout) {
      //
      // Display Layout
      //
      layout = new View.Layout({model: context});
      projectLayout.contentRegion.show(layout);
    });

    return;

    //
    // Initialize header (static part)
    //
    var fetchingProject = app.request('project:entity', projectSlug);
    var fetchingLanguages = app.request('language:entities', projectSlug);
    $.when(fetchingProject, fetchingLanguages).done(function(project, languages) {
      var headerState = new Model.HeaderState({
        context: context,
        project: project,
        languages: languages
      });

      var headerView = new View.Header({
        model: headerState
      });

      layout.headerRegion.show(headerView);
    });

    var filtersView = new View.Filters();
    layout.filtersRegion.show(filtersView);

    translations = new TranslationCommitCollection([], {projectSlug: projectSlug});

    //
    // Init events binding
    //

    // On context change
    context.on('change', function() {
      console.log('context change');
      var source = this.get('source');
      var target = this.get('target');

      if (!source || !target) {
        // Nothing to show
        return;
      }

      if (context.hasChanged('source') || context.hasChanged('target')) {
        translations.sourceLocale = source;
        translations.targetLocale = target;

        var defer = $.Deferred();
        translations.fetch({
          success: function(data) {
            defer.resolve(data);
          }
        });

        var fetchingTranslations = defer.promise();

        $.when(fetchingTranslations).done(function(translationCommits) {
          var translationListView = new View.TranslationList({collection: translationCommits});
          layout.translationListRegion.show(translationListView);
        });
      }

      // On translation selected
      translations.on('select:one', function(translation) {
        var actionBarView = new View.ActionBar({model: translation});
        layout.actionBarRegion.show(actionBarView);

        var translationEditView = new View.TranslationEdit({model: translation});
        layout.translationEditRegion.show(translationEditView);

        translation.fetch();
      })
    });
  }

  return function(projectSlug, source, target, translationId) {
    // Unbind previous events
    if (context)
      context.off();
    if (translations)
      translations.off();


    context = new Model.Context({
      project: projectSlug
    });

    initApp();

    context.set({
      source: source || null,
      target: target || null,
    });

  }

});
