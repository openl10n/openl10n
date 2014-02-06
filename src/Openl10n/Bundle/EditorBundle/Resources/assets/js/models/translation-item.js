;(function(win, doc, Editor) {

  Editor.Models.Translation = Backbone.Model.extend({
    url: function() {
      return Routing.generate('openl10n_editorapi_get_translation', {
        'project': Editor.project.get('id'),
        'target': this.get('target_locale'),
        'hash': this.id,
        'source': this.get('source_locale')
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

})(window, window.document, window.Editor)
