;(function(win, doc, editor) {

  editor.models.Translation = Backbone.Model.extend({
    url: function() {
      return Routing.generate('openl10n_editorapi_get_translation', {
        'project': editor.page.get('project'),
        'domain': this.get('domain'),
        'target': this.get('target_locale'),
        'hash': this.id,
        'source': editor.page.get('source')
      });
    },

    defaults: {
      // REST attrbutes
      domain: '',
      is_approved: false,
      is_translated: false,
      key: '',
      source_locale: '',
      target_locale: '',
      project: '',
      source_phrase: '',
      target_phrase: '',

      // UI attributes
      selected: false,
    }
  });

})(window, window.document, window.editor)
