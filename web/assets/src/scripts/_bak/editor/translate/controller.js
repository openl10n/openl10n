define(['marionette'], function(Marionette) {
  var Controller = Marionette.Controller.extend({
    initialize: function(options) {
      this.app = options.app;
    },

    listTranslations: function(source, target) {
      var context = this.app.context;
      var translationList = this.app.translationList;

      context.set({
        source_locale: source,
        target_locale: target,
      });

      translationList.fetch({
        success: function() {
          if (0 === translationList.length) return;

          // Select first translation
          translationList.at(0).set('selected', true);
        }
      });
    },

    showTranslation: function(source, target, hash) {
      var context = this.app.context;
      var translationList = this.app.translationList;

      // this.app.filterBag.set({
      //   'domain': 'strings',
      //   'translated': 0,
      //   'text': 'music',
      //   //'approved': 0,
      // }, {silent: true});

      context.set({
        source_locale: source,
        target_locale: target,
      });

      translationList.fetch({
        success: function() {
          // Select given translation
          var translation = translationList.get(hash);

          if (!translation) return;

          translation.set('selected', true);
        }
      });
    }
  });

  return Controller;
});
