;(function(win, doc, editor) {

  editor.models.TranslationList = Backbone.Collection.extend({
    model: editor.models.Translation,

    url: function() {
      return Routing.generate('openl10n_editorapi_get_translations', {
        'project': editor.page.get('project'),
        'domain': this.domain,
        'target': this.target,
        'source': editor.page.get('source')
      });
    },

    parse: function(response) {
      return response.translations;
    },

    initialize: function(models, options) {
      options || (options = {});

      // Init arguments
      this.domain = options.domain;
      this.target = options.target;
      this.selectedItem = null;

      // Events
      this.listenTo(editor.page, 'change:hash', this.selectItem.bind(this));
    },

    selectItem: function() {
      var hash = editor.page.get('hash');

      if (this.selectedItem)
        this.selectedItem.set('selected', false);

      var model = this.get(hash);
      if (!model)
        return;

      model.set('selected', true);
      this.selectedItem = model;
    }

  });
})(window, window.document, window.editor)
