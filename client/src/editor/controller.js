var $ = require('jquery');
var _ = require('underscore');

var Backbone = require('backbone');
var Controller = require('../framework/controller');
var EditorLayoutView = require('./views/editor-layout-view');
var TranslationListView = require('./views/translation-list-view');
var LanguageOverlayView = require('./views/language-overlay-view');
var ResourceListView = require('./views/resource-list-view');
var LocaleChooserView = require('./views/locale-chooser-view');
var ActionBarView = require('./views/action-bar-view');
var TranslationEditView = require('./views/translation-edit-view');
var TranslationMetaTabsView = require('./views/translation-meta-tabs-view');
var FiltersView = require('./views/filters-view');
var StatsView = require('./views/stats-view');
var Context = require('./models/context');
var FilterBag = require('./models/filter-bag');
var TranslationCommitCollection = require('./models/translation-commits')

var layoutChannel = require('../framework/radio').channel('layout');
var modelChannel = require('../framework/radio').channel('model');

module.exports = Controller.extend({
  channelName: 'editor',

  start: function() {
  },

  stop: function() {
    this.stopListening();
    delete this.projectSlug;
    delete this.context;
    delete this.filters;
    delete this.translations;
  },

  translate: function(projectSlug, source, target, translationId, filters) {
    this._initEditor(projectSlug, source, target, translationId, filters);
  },

  proofread: function(projectSlug, source, target, translationId, filters) {
    this._initEditor(projectSlug, source, target, translationId, filters);
  },

  _initEditor: function(projectSlug, source, target, translationId, filters) {
    var _this = this;

    this.projectSlug = projectSlug;
    this.translationId = translationId;
    this.context = new Context({source: source, target: target});
    this.filters = new FilterBag(filters);
    this.translations = new TranslationCommitCollection([], {
      // Models
      projectSlug: this.projectSlug,
      context: this.context,
      filters: this.filters,
      // Backbone.Cycle options
      // initialSelection: 'first',
      // selectIfRemoved: "next"
    });

    this.listenTo(this.context, 'change', this.updateTranslations);
    this.listenTo(this.context, 'change', this.updateRoute);
    this.listenTo(this.filters, 'change', this.updateTranslations);
    this.listenTo(this.filters, 'change', this.updateRoute);
    this.listenTo(this.translations, 'select:one', this.showTranslation);
    this.listenTo(this.translations, 'select:one', this.updateRoute);

    var projectViewRendering = layoutChannel.reqres.request('project', projectSlug);
    var projectFetching = modelChannel.reqres.request('project', projectSlug);
    var resourcesFetching = modelChannel.reqres.request('resources', projectSlug);
    var languagesFetching = modelChannel.reqres.request('languages', projectSlug);

    $
      .when(projectViewRendering, projectFetching, languagesFetching, resourcesFetching)
      .done(function(projectView, project, languages, resources) {
        _this.languages = languages;
        _this.resources = resources;

        if (!_this.context.get('source')) {
          _this.context.set('source', project.get('default_locale'))
        }

        // Layout
        _this.layout = new EditorLayoutView();
        projectView.contentRegion.show(_this.layout);

        // Language overlay
        var languageOverlayView = new LanguageOverlayView({model: _this.context});
        _this.layout.languageOverlayRegion.show(languageOverlayView);

        // Filters
        var filtersView = new FiltersView({model: _this.filters});
        _this.layout.filtersRegion.show(filtersView);

        // Stats
        var statsView = new StatsView({collection: _this.translations, model: _this.filters});
        _this.layout.statsRegion.show(statsView);

        // Languages chooser
        var sourceLocaleChooserView = new LocaleChooserView({
          collection: _this.languages,
          model: _this.context,
          modelAttribute: 'source'
        });
        var targetLocaleChooserView = new LocaleChooserView({
          collection: _this.languages,
          model: _this.context,
          modelAttribute: 'target'
        });
        _this.layout.sourceChooserRegion.show(sourceLocaleChooserView);
        _this.layout.targetChooserRegion.show(targetLocaleChooserView);

        // Resource list
        var resourceListView = new ResourceListView({collection: _this.resources});
        _this.layout.resourcesListRegion.show(resourceListView);

        // Translation list
        var translationListView = new TranslationListView({collection: _this.translations});
        _this.layout.translationsListRegion.show(translationListView);

        // Finally
        _this.updateTranslations();
      });
  },

  //
  // Update the route based on the context, selected translation and filters
  //
  updateRoute: function() {
    var path = ['projects', this.projectSlug, 'translate'];

    var parts = [
      this.context.get('source'),
      this.context.get('target'),
      this.translationId
    ];

    for (var i in parts) {
      var part = parts[i];
      if (part) {
        path.push(part);
      } else {
        break;
      }
    }

    var params = {};
    var filters = this.filters.toJSON();

    // Build query params
    for (var name in filters) {
      var value = filters[name];
      if (null !== value) {
        params[name] = value;
      }
    }

    // Build full URL
    var url = path.join('/');
    if (Object.keys(params).length > 0) {
      url += '?' + $.param(params);
    }

    // Navigate "silently" to the given URL
    Backbone.history.navigate(url, {replace: true});
  },

  //
  // Update the translations list when the context of the Editor changes.
  //
  updateTranslations: function() {
    var _this = this;

    if (!this.context.get('source') || !this.context.get('target')) {
      this.translations.reset();
      // this.layout.actionBarRegion.close();
      // this.layout.translationEditRegion.close();
      return;
    }

    this.translations.fetch().done(function() {
      var translation;

      // If we get an id, try to retrieve it
      if (_this.translationId) {
        translation = _this.translations.get(_this.translationId);
      }

      // If given translation is not found on current list, then select first one
      if (!translation && _this.translations.length > 0) {
        translation = _this.translations.at(0);
      }

      // Select translation if any
      if (translation) {
        translation.select();
      }
    });
  },

  //
  // Render the views for the selected translation.
  //
  showTranslation: function(translation) {
    this.translationId = translation.id;

    var actionBarView = new ActionBarView({model: translation});
    var translationEditView = new TranslationEditView({model: translation});
    var tabsView = new TranslationMetaTabsView();
    // var informationTabView = new TranslateInformationTabView({model: translation});

    this.layout.actionBarRegion.show(actionBarView);
    this.layout.translationEditRegion.show(translationEditView);
    this.layout.translationMetaTabsRegion.show(tabsView);

    if (!translation.get('edited')) {
      translation.fetch();
    }
  },
});
