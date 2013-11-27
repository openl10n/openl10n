/**
 * Page mediator
 */
;(function(win, doc, editor) {

  editor.models.Page = Backbone.Model.extend({

    defaults: {
      project: null,
      domain: null,
      source: 'en',
      target: null,
    },

    initialize: function(attributes, options) {
      var _this = this;

      this.listDeferred = null;
      this.itemDeferred = null;

      this.on('change', this.showTranslationList);
      this.on('change', this.updateUrl);

      // Update translation list
      this.on('change:domain', this.markHasToBeRefresh);
      this.on('change:source', this.markHasToBeRefresh);
      this.on('change:target', this.markHasToBeRefresh);

      // Show translation
      this.on('change:hash', this.showTranslation);

      // Header
      this.on('change:domain', this.renderHeader);
    },

    renderHeader: function() {
      if (!this.headerView) {
        this.headerView = new editor.views.HeaderView();
        editor.layout.header.show(this.headerView);
      } else {
        this.headerView.render();
      }
    },

    updateUrl: function() {
      var path = [];
      if (this.get('target')) {
        path.push(this.get('target'));
      }
      if (this.get('domain')) {
        path.push(this.get('domain'));
      }
      if (this.get('hash')) {
        path.push(this.get('hash'));
      }
      path = path.join('/');

      Backbone.history.navigate(path);
    },

    markHasToBeRefresh: function() {
      this.hasToBeRefresh = true;
    },

    showTranslationList: function() {
      if (!this.hasToBeRefresh) return;

      var translationList = new editor.models.TranslationList([], {
        domain: this.get('domain'),
        target: this.get('target')
      });

      this.listDeferred = translationList.fetch({
        success: function() {
          var translationListView = new editor.views.TranslationListView({
            collection: translationList
          });

          // Show only after success fetch to avoid "jump cut" effect
          editor.layout.translationList.show(translationListView);
        }
      });

      this.translationList = translationList;

      this.hasToBeRefresh = false;

      // As the translation list has changed, we also need to update translation edit view
      this.listDeferred.done(function() {
        this.showTranslation();
      }.bind(this));
    },

    showTranslation: function() {
      var translation;
      var hash;

      hash = this.get('hash');
      if (!hash)
        return;

      // Search translation in current translation list
      if (this.translationList) {
        translation = this.translationList.get(hash);
        this.translationList.selectItem();
      }

      // If not found, then created new one with given hash
      if (!translation) {
        translation = new editor.models.Translation({
          id: this.get('hash'),
          domain: this.get('domain'),
          target_locale: this.get('target')
        });
      }

      var translationEditView = new editor.views.TranslationEditView({
        model: translation
      });

      editor.layout.translationEdit.show(translationEditView);

      var actionsView = new editor.views.ActionsView({
        model: translation
      });

      editor.layout.actions.show(actionsView);

      //translation.set('selected', true);

      this.itemDeferred = translation.fetch({
        error: function() {
          Essage.show({
            message: 'Unable to display translation :(',
            status: 'error'
          }, 2000);
        }
      });
    },

  });

})(window, window.document, window.editor)
