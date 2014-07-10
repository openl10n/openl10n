var $ = require('jquery');
var Backbone = require('backbone');

module.exports = Backbone.Collection.extend({
  url: function() {
    var attributes = {
      'project': this.projectSlug,
      'source': this.context.get('source'),
      'target': this.context.get('target'),
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

    return '/api/translation_commits?' + $.param(attributes);
  }

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

  initialize: function(options) {
    // BackboneSelect.One.applyTo(this, models, options);

    this.projectSlug = options.projectSlug;
    this.context = options.context;
    this.filters = options.filters;

    this.stats = {
      all: 0,
      untranslated: 0,
      unapproved: 0
    };
  },

})
