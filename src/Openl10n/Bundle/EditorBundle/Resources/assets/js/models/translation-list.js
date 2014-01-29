;(function(win, doc, Editor) {

  Editor.Models.TranslationList = Backbone.Collection.extend({
    model: Editor.Models.Translation,

    url: function() {
      return Routing.generate('openl10n_editorapi_get_translations', {
        'project': Editor.project.get('id'),
        'domain': Editor.context.get('domain') ? Editor.context.get('domain') : '*',
        'target': Editor.context.get('target'),
        'source': Editor.context.get('source'),
        'text': Editor.context.get('text') ? Editor.context.get('text') : null,
        'translated': Editor.context.get('translated') ? Editor.context.get('translated') : null,
        'approved': Editor.context.get('approved') ? Editor.context.get('approved') : null,
      });
    },

    parse: function(response) {
      return response.translations;
    },

    initialize: function(models, options) {
      options || (options = {});

      // Init arguments
      //this.domain = options.domain;
      //this.target = options.target;
      this.selectedItem = null;

      // Events
      this.listenTo(Editor.context, 'change:hash', function(evt, hash) {
        this.selectItem(hash);
      }.bind(this));
    },

    selectItem: function(hash) {
      if (this.selectedItem)
        this.selectedItem.set('selected', false);

      var model = this.get(hash);
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
      Editor.context.set('hash', nextItem.id);
    },

    selectPreviousItem: function() {
      if (null === this.selectedItem)
        return;

      var currentIndex = this.indexOf(this.selectedItem);
      var previousItemIndex = Math.max(0, currentIndex - 1);
      var previousItem = this.at(previousItemIndex);
      Editor.context.set('hash', previousItem.id);
    }

  });
})(window, window.document, window.Editor)
