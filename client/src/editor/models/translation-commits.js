var $ = require('jquery');
var _ = require('underscore');
var Backbone = require('backbone');
var BackboneCycle = require('backbone.cycle');
var TranslationCommit = require('./translation-commit');

module.exports = Backbone.Collection.extend({
  url: function() {
    var attributes = {
      'project': this.projectSlug
    };

    // Manage filters
    if (null !== this.filters.get('translated')) {
      attributes.translated = this.filters.get('translated');
    }
    if (null !== this.filters.get('approved')) {
      attributes.approved = this.filters.get('approved');
    }
    if (this.filters.get('text')) {
      attributes.text = this.filters.get('text');
    }

    return '/api/translation_commits/'
      + this.context.get('source') + '/'
      + this.context.get('target') + '?'
      + $.param(attributes);
  },

  defaults: {
    key: '',
    source_locale: '',
    source_phrase: '',
    target_locale: '',
    target_phrase: '',
    is_translated: false,
    is_approved: false,
    edited: false
  },

  model: TranslationCommit,

  initialize: function(models, options) {
    BackboneCycle.SelectableCollection.applyTo( this, models, options );


    this.projectSlug = options.projectSlug;
    this.context = options.context;
    this.filters = options.filters;

    this.stats = {
      all: 0,
      untranslated: 0,
      unapproved: 0
    };
  },

  parse: function(response) {
    this.stats.all = response.length;
    this.stats.untranslated = _(response).where({'is_translated': false}).length;
    this.stats.unapproved = _(response).where({'is_translated': true, 'is_approved': false}).length;
    this.stats.approved = _(response).where({'is_translated': true, 'is_approved': true}).length;

    return response;
  },

  reset: function(models, options) {
    this.stats.all = 0;
    this.stats.untranslated = 0;
    this.stats.unapproved = 0;
    this.stats.approved = 0;

    return Backbone.Collection.prototype.reset.call(this, models, options);
  }

})
