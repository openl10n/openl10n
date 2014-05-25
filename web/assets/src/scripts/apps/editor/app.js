define([
  'app',
  'apps/editor/router',
  'apps/editor/controller',
  'apps/editor/translate/models',
  'apps/editor/translate/views',
  'entities/translation_commit/collection'
], function(app, Router, Controller, Model, View, TranslationList) {

  app.module('Editor', function(Editor, app, Backbone, Marionette, $, _) {
    Editor.startWithParent = false;

    Editor.projectSlug = null;
    Editor.context = null;
    Editor.layout = null;

    Editor.onStart = function() {
      console.log('start editor');
      // Do something on module start
    };

    Editor.onStop = function() {
      // Do something on module stop
      console.log('stop editor');
      app.Editor.projectSlug = null;
    };
  });

  // Init Router
  app.addInitializer(function() {
    var controller = new Controller();
    var router = new Router({controller: controller});
  });

  app.reqres.setHandler('layout:editor', function(projectSlug) {
    var defer = $.Deferred();

    if (app.Editor.projectSlug === projectSlug) {
      defer.resolve(app.Editor.layout);

      return defer.promise();
    }

    app.Editor.projectSlug = projectSlug;
    app.Editor.context = new Model.Context({});

    var translationList = new TranslationList([], {
      projectSlug: projectSlug,
      context: app.Editor.context,
    });


    app.Editor.layout = new View.Layout({
      model: app.Editor.context,
      collection: translationList
    });

    // init events ?????
    // x on context change, fetch translationList
    // - on translationList select one, display edit view
    // - on translationList select multi, display bulk edit view

    app.Editor.context.on('change', function() {
      if (app.Editor.context.get('source') && app.Editor.context.get('target'))
        translationList.fetch();
    })

    // translations.on('select:one', function(translation) {
    //   var actionBarView = new View.ActionBar({model: translation});
    //   layout.actionBarRegion.show(actionBarView);

    //   var translationEditView = new View.TranslationEdit({model: translation});
    //   layout.translationEditRegion.show(translationEditView);

    //   translation.fetch();
    // })

    // app.Editor.context.set({
    //   source: 'en',
    //   target: 'fr'
    // })

    //projectLayout.contentRegion.show(layout);
    //var translationListView = new TranslationListView({collection: translationList})

    defer.resolve(app.Editor.layout);

    return defer.promise();

    // editoLayout contains
    // - resource list
    // - source select + target select
    // - filter form (search input)
    // - translation-list
    // - quick-actions
    // - translation-edit
    //   - translation-edit
    //   - tabs
    //   - N sections (suggestion, histo, etc.)
    //
  });
});
