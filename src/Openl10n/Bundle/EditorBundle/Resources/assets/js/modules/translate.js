;(function(win, doc, Editor) {

  Editor.Modules.Translate = {
    attach: function(app) {
      var _this = this;

      app.module('Translate').on('start', function(options) {
        this.listenTo(Editor.context, 'change:domain', _this.fetchTranslations);
        this.listenTo(Editor.context, 'change:source', _this.fetchTranslations);
        this.listenTo(Editor.context, 'change:target', _this.fetchTranslations);

        this.listenTo(Editor.context, 'change:text', _this.fetchTranslations);
        this.listenTo(Editor.context, 'change:translated', _this.fetchTranslations);
        this.listenTo(Editor.context, 'change:approved', _this.fetchTranslations);

        this.listenTo(Editor.context, 'change:hash', _this.showTranslation);
        this.listenTo(Editor.context, 'change:source', _this.showTranslation);
        this.listenTo(Editor.context, 'change:target', _this.showTranslation);
      });
    },

    fetchTranslations: function() {
      Editor.translations = new Editor.Models.TranslationList();
      this.translationDeferred = Editor.translations.fetch();

      /* done vs. always */
      this.translationDeferred.done(function() {
        var translationsListView = new Editor.Views.TranslationListView({
          collection: Editor.translations
        });

        // Show only after success fetch to avoid "jump cut" effect
        Editor.layout.translationList.show(translationsListView);
      });
    },

    showTranslation: function() {
      if (!this.translationDeferred) {
        console.log('[DEBUG] Erk, seems there is no translation list');
        return;
      }

      this.translationDeferred.done(function() {
        var hash = Editor.context.get('hash');

        var translation = Editor.translations.selectItem(hash);
        if (!translation) {
          console.log('[DEBUG] Erk, did find the translation');
          return;
        }

        var translationEditView = new Editor.Views.TranslationEditView({
          model: translation
        });
        Editor.layout.translationEdit.show(translationEditView);

        var actionsView = new Editor.Views.ActionsView({
          model: translation
        });
        Editor.layout.actionsBar.show(actionsView);

        console.log('show translation ' + hash);
      });
    }
  };

})(window, window.document, window.Editor)
