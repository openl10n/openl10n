/**
 * Application definition
 */
;(function(win, doc, Editor) {

  Editor.app = new Backbone.Marionette.Application();

  Editor.app.on("initialize:after", function(options) {
    Backbone.history.start({pushState: false});

    // Freeze the object
    if (typeof Object.freeze === "function") {
      Object.freeze(this);
    }
  });

  Editor.app.addInitializer(function(options) {
    console.log('[DEBUG] app started');

    // Models
    Editor.project = new Backbone.Model(options.project);
    Editor.domains = new Backbone.Collection(options.domains);
    Editor.languages = new Backbone.Collection(options.languages);
    Editor.context = new Editor.Models.Context({
      source: Editor.project.get('locale')
    });

    // Views
    Editor.layout = new Editor.Views.AppLayout();
    Editor.headerView = new Editor.Views.HeaderView();
    Editor.layout.header.show(Editor.headerView);
    Editor.layout.filter.show(new Editor.Views.FilterView);

    // Routing
    Editor.controller = new Editor.Controller();
    Editor.router = new Editor.Router({
      controller: Editor.controller
    });

    // Modules
    Editor.Modules.Translate.attach(this);
  });

})(window, window.document, window.Editor)
