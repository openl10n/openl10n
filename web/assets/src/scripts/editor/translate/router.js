define(['marionette'], function(Marionette) {
  return Marionette.AppRouter.extend({
    appRoutes: {
      ':source/:target': 'listTranslations',
      ':source/:target/:hash': 'showTranslation',
    },

    initialize: function(options) {
      var _this = this;
      this.app = options.app;

      this.app.context.on('change', function() {
        _this.updateUrl();
      })

      this.app.translationList.on('change:selected', function(translation) {
        if (!translation.get('selected'))
          return;

        _this.updateUrl();
      });
    },

    updateUrl: function() {
      var urlParts = [
        this.app.context.get('source_locale'),
        this.app.context.get('target_locale'),
      ];

      var translation = this.app.translationList.selectedItem;
      if (translation)
        urlParts.push(translation.id);

      Backbone.history.navigate(urlParts.join('/'));
    }
  });
})
