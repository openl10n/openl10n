;(function(win, doc, Editor) {

  Editor.Controller = Marionette.Controller.extend({
    initialize: function() {
    },

    index: function() {
      console.log('[DEBUG] index action');

      var path = Editor.project.get('locale');

      Backbone.history.navigate(path, {trigger: true});
    },

    showLanguage: function(target) {
      console.log('[DEBUG] showLanguage action');

      Editor.context.set('target', target);
    },

    listTranslation: function(target, domain) {
      console.log('[DEBUG] listTranslation action');

      if (domain == '*' || !Editor.domains.get(domain)) {
        Editor.context.set({
          'target': target,
          'domain': null
        });

        return;
      }

      Editor.context.set({
        'target': target,
        'domain': domain
      });
    },

    showTranslation: function(target, domain, hash) {
      if (domain != '*' && !Editor.domains.get(domain)) {
        Editor.context.set({
          'target': target,
          'domain': null,
          'hash': hash
        });
        return;
      }

      Editor.context.set({
        'target': target,
        'domain': domain,
        'hash': hash
      });
    },

    notFound: function() {
      console.log('[DEBUG] route not found');
    }
  });

})(window, window.document, window.Editor)
