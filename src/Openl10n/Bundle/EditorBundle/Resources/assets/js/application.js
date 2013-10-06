/**
 * Application definition
 */
;(function(win, doc, editor) {

  editor.app = new Backbone.Marionette.Application();

  editor.app.on("initialize:after", function(options) {
    Backbone.history.start({pushState: false});

    // Freeze the object
    if (typeof Object.freeze === "function") {
      Object.freeze(this);
    }
  });

  editor.app.addInitializer(function(options) {
    // Instantiate the layout
    editor.layout = new editor.views.AppLayout();

    // Instantiate the router on initialization
    editor.controller = new editor.Controller();
    editor.router = new editor.Router({
      controller: editor.controller
    });

    // Init Page controller
    editor.page = new editor.models.Page({
      project: options.project
    });

  });

})(window, window.document, window.editor)
