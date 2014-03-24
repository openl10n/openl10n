define(['backbone', 'editor/common/backend-router'], function(Backbone, backendRouter) {

  var Translation = Backbone.Model.extend({
    url: function() {
      return backendRouter.generate('openl10n_editorapi_get_translation', {
        'project': this.get('project'),
        'target': this.get('target_locale'),
        'source': this.get('source_locale'),
        'hash': this.id,
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
      is_dirty: false
    },

    initialize: function(models, options) {
      options || (options = {});

      // Init arguments
      this.context = options.context;
    },

    _onSync: function() {
      this.set('is_dirty', false, {silent: true});
    }

    // save: function(attributes, options) {
    //   attributes || (attributes = {});
    //   Backbone.Model.prototype.save.call(this, attributes, options);
    // }
  });

  return Translation;
});
