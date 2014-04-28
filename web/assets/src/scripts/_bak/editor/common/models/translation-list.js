define([
  'backbone',
  'editor/common/models/translation',
  'editor/common/backend-router',
  'editor/common/msgbus',
], function(Backbone, Translation, backendRouter, msgBus) {

  var TranslationList = Backbone.Collection.extend({
    model: Translation,

    url: function() {
      return backendRouter.generate('openl10n_editorapi_get_translations', {
        // Context
        'project': this.context.get('project'),
        'target': this.context.get('target_locale'),
        'source': this.context.get('source_locale'),
        // Filters
        'domain': this.filterBag.get('domain'),
        'translated': this.filterBag.get('translated'),
        'approved': this.filterBag.get('approved'),
        'text': this.filterBag.get('text'),
      });
    },

    parse: function(response) {
      return response.translations;
    },

    initialize: function(models, options) {
      options || (options = {});

      // Init arguments
      //this.domain = options.domain;
      this.context = options.context;
      this.filterBag = options.filterBag;

      this.selectedItem = null;

      // Listen on model change
      this.on('change:selected', function(translation) {
        if (this.selectedItem)
          this.selectedItem.set('selected', false);

        this.selectedItem = translation;
      });
    },

    selectItem: function(id) {
      if (this.selectedItem)
        this.selectedItem.set('selected', false);

      var model = this.get(id);
      if (!model)
        return;

      model.set('selected', true);
      this.selectedItem = model;

      return model;
    },

    selectNextItem: function() {
      if (null === this.selectedItem)
        return;

      var currentIndex = this.indexOf(this.selectedItem);
      var nextItemIndex = Math.min(currentIndex + 1, this.length - 1);
      var nextItem = this.at(nextItemIndex);

      nextItem.set('selected', true);
      this.selectedItem = nextItem;
    },

    selectPreviousItem: function() {
      if (null === this.selectedItem)
        return;

      var currentIndex = this.indexOf(this.selectedItem);
      var previousItemIndex = Math.max(0, currentIndex - 1);
      var previousItem = this.at(previousItemIndex);

      previousItem.set('selected', true);
      this.selectedItem = previousItem;
    }

  });

  return TranslationList;
});
