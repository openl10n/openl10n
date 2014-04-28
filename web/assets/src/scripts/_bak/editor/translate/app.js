define([
  'marionette',
  'editor/translate/controller',
  'editor/translate/router',
  'editor/translate/views/layout',
  'editor/translate/views/header',
  'editor/translate/views/actions',
  'editor/translate/views/filters',
  'editor/translate/views/translation-list',
  'editor/translate/views/translation-edit',
  'editor/common/models/translation-list',
  'editor/common/models/context',
  'editor/common/models/filter-bag',
  'editor/common/msgbus',
], function(
  Marionette,
  Controller,
  Router,
  Layout,
  HeaderView,
  ActionsView,
  FiltersView,
  TranslationListView,
  TranslationEditView,
  TranslationList,
  Context,
  FilterBag,
  msgBus
) {

  var TranslateApp = Marionette.Module.extend({
    //startWithParent: false,

    // initialize: function(options, moduleName, app) {
    //   this.context = app.context;
    // },

    onStart: function(options) {
      options = options || {};

      // Init context var
      var context = new Context({
        project: options.project.id,
        source_locale: options.project.locale,
        target_locale: options.project.locale,
      });
      var filterBag = new FilterBag();

      // Layout
      var layout = new Layout({el: 'body'});

      // Header
      var headerView = new HeaderView({context: context, filterBag: filterBag});
      layout.header.show(headerView);

      // Filters
      var filtersView = new FiltersView({model: filterBag, translationList: translationList});
      layout.filters.show(filtersView);

      // Init translation list view
      var translationList = new TranslationList([], {
        context: context,
        filterBag: filterBag,
      })
      var translationListView = new TranslationListView({collection: translationList});
      layout.translationList.show(translationListView);

      // When a translation is selected, then prepare the edit view
      translationList.on('change:selected', function(translation) {
        // For the unselected translation, do nothing
        // (should I unset oldView or Marionette already do it?)
        if (!translation.get('selected')) return;

        var actionsView = new ActionsView({model: translation});
        layout.actions.show(actionsView);

        var translationEditView = new TranslationEditView({model: translation});
        layout.translationEdit.show(translationEditView);
        translation.fetch();
      });

      // When context or filters are updated, then refresh translations
      context.on('change', function() {
        translationList.fetch();
      });
      filterBag.on('change', function() {
        translationList.fetch();
      });

      this.translationList = translationList;
      this.context = context;
      this.filterBag = filterBag;

      // Initialize router
      var controller = new Controller({app: this});
      var router = new Router({
        controller: controller,
        app: this
      });

    },

    onStop: function(options) {
    },
  });

  return TranslateApp;
});
