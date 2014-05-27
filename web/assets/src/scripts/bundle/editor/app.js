define([
  'underscore',
  'backbone',
  'marionette',
  'msgbus',

  'bundle/editor/models/context',

  'bundle/editor/views/actionbar',
  'bundle/editor/views/filters',
  'bundle/editor/views/layout',
  'bundle/editor/views/locale_chooser',
  'bundle/editor/views/resources_list',
  'bundle/editor/views/stats',
  'bundle/editor/views/translate/layout',
  'bundle/editor/views/translations_list',
  'bundle/editor/views/translate/tabs',
  'bundle/editor/views/translate/information_tab',

  'entities/language/collection',
  'entities/resource/collection',
  'entities/translation_commit/collection',
], function(
  _,
  Backbone,
  Marionette,
  msgbus,

  Context,

  ActionBarView,
  FiltersView,
  Layout,
  LocaleChooserView,
  ResourcesListView,
  StatsView,
  TranslationEditView,
  TranslationsListView,
  TranslateTabsView,
  TranslateInformationTabView,

  LanguagesList,
  ResourcesList,
  TranslationsList
) {

  //
  // Editor Application
  //

  // TODO:
  // [x] init context (source, target, filters (= resource + search + translated...) + mode (translate/approve))
  // [x] resourcesList = new
  // [x] translationsList = new
  // [x] show layout (<- project layout)
  // [x] layout.show(resourceListView)
  // [x] layout.show(new sourceLocaleListView(model: context))
  // [x] layout.show(new targetLocaleListView(model: context))
  // [x] layout.show(filterFormView)
  // [x] on context change, translationsList.fetch
  // [x] on translationsList select one,
  //   layout.show(translationEditView)
  //   + layout.show(translationHistoryView) + other tabs
  //   + layout.show(translationActionBar)
  //   + layout.show(translationEditTabs)
  // select next ???? event?

  function EditorApp(projectSlug) {
    this.projectSlug = projectSlug;
  }

  _.extend(EditorApp.prototype, Backbone.Events, {
    //
    // Initialize the Editor application.
    // This will have a direct impact on main app layout.
    //
    initialize: function(regionContainer) {
      this._initModels();
      this._initViews(regionContainer);
      this._initEvents();

      return this;
    },

    //
    // Remove the current Editor from the application layout.
    // Be sure to free all the initialized listeners.
    //
    destroy: function() {
      this.stopListening();
      this.layout.close();
      this.projectSlug = null;

      return this;
    },

    setMode: function(mode) {
      // TODO
    },

    //
    // Init models used by the Editor
    //
    _initModels: function() {
      // instanciate models
      this.context = new Context();
      // this.filters = new FilterBag();

      this.resourcesList = new ResourcesList([], {
        projectSlug: this.projectSlug
      });

      this.languagesList = new LanguagesList([], {
        projectSlug: this.projectSlug
      });

      this.translationsList = new TranslationsList([], {
        projectSlug: this.projectSlug,
        context: this.context,
        //filters: this.filters
      });

      // sync models
      this.languagesList.fetch();
      this.resourcesList.fetch();
    },


    //
    // Render the Editor layout.
    //
    _initViews: function(regionContainer) {
      this.layout = new Layout();
      regionContainer.show(this.layout);

      // instanciate views
      var sourceChooserView = new LocaleChooserView({
        contextAttribute: 'source',
        context: this.context,
        languagesList: this.languagesList
      });
      var targetChooserView = new LocaleChooserView({
        contextAttribute: 'target',
        context: this.context,
        languagesList: this.languagesList
      });
      var resourcesListView = new ResourcesListView({
        collection: this.resourcesList
      });
      var filtersView = new FiltersView({
        model: this.context
      });
      var stastsView = new StatsView({
        collection: this.translationsList
      })
      var translationsListView = new TranslationsListView({
        collection: this.translationsList
      });

      // render views
      this.layout.filtersRegion.show(filtersView);
      this.layout.sourceChooserRegion.show(sourceChooserView);
      this.layout.targetChooserRegion.show(targetChooserView);
      this.layout.resourcesListRegion.show(resourcesListView);
      this.layout.translationsListRegion.show(translationsListView);
      this.layout.statsRegion.show(stastsView);
    },

    //
    // Start events listener.
    //
    _initEvents: function() {
      // Local models events
      this.listenTo(this.context, 'change', this.updateRoute);
      this.listenTo(this.context, 'change', this.updateTranslations);
      this.listenTo(this.translationsList, 'select:one', this.showTranslation);

      // Global events (namespaced)
      // this.listenTo(msgbus.vent, 'editor:previous', this.selectPreviousTranslation);
      // this.listenTo(msgbus.vent, 'editor:next', this.selectNextTranslation);
    },

    //
    // Update the route based on the context, selected translation and filters
    //
    updateRoute: function() {
      var parts = ['projects', this.projectSlug, 'translate'];

      if (this.context.get('source')){
        parts.push(this.context.get('source'));
      }
      if (this.context.get('target')){
        parts.push(this.context.get('target'));
      }

      Backbone.history.navigate(parts.join('/'), {replace: true});
    },

    //
    // Update the translations list when the context of the Editor changes.
    //
    updateTranslations: function() {
      if (!this.context.get('source') || !this.context.get('target')) {
        this.translationsList.reset();
        this.layout.actionBarRegion.close();
        this.layout.translationEditRegion.close();
        return;
      }

      this.translationsList.fetch();
    },

    //
    // Render the views for the selected translation.
    //
    showTranslation: function(translation) {
      var actionBarView = new ActionBarView({model: translation});
      var translationEditView = new TranslationEditView({model: translation});
      var tabsView = new TranslateTabsView();
      var informationTabView = new TranslateInformationTabView({model: translation});

      this.layout.actionBarRegion.show(actionBarView);
      this.layout.translationEditRegion.show(translationEditView);
      translationEditView.tabsRegion.show(tabsView);
      translationEditView.informationTabRegion.show(informationTabView);

      translation.fetch();
    },

    //
    // Select the preivous translation of the list
    //
    selectPreviousTranslation: function() {
    },

    //
    // Select the next translation of the list
    //
    selectNextTranslation: function() {
    },

  });

  return EditorApp;
});
