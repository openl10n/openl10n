define([
  'underscore',
  'backbone',
  'marionette',
  'app',
], function(_, Backbone, Marionette, app) {

  // bundle/
  //   editor/
  //     app.js (this file)
  //     router.js
  //     controller.js
  //     models/
  //       context
  //     templates/
  //       layout.tpl
  //     views/
  //       translation/
  //         actionbar
  //         edit
  //         tabs
  //         history
  //         information
  //       translation_bulk/
  //         actionbar?
  //       layout
  //       translation_list
  //       translation_item
  //       source_chooser
  //       target_chooser
  //       resource_list
  //       resource_item
  //       filters
  //   project/
  //     controller/
  //       list
  //       new
  //       show
  //     views/
  //       list/
  //         layout
  //         project_item
  //         project_list
  //         ...
  //       new/
  //         layout
  //         form
  //         ...
  //       show/
  //         layout
  //         sidebar
  //         resource_item
  //         resource_list
  //         language_item
  //         language_list
  //     templates/
  //       show/
  //     router
  //

  function Editor(projectSlug) {
    this.projectSlug = projectSlug;
  }


  _.extend(Editor.prototype, {}, {
    initialize: function() {
      // init context (source, target, filters (= resource + search + translated...) + mode (translate/approve))
      // new msgbus?
      // show layout (<- project layout)
      // resourceList = new
      // translationList = new
      // layout.show(resourceListView)
      // layout.show(new sourceLocaleListView(model: context))
      // layout.show(new targetLocaleListView(model: context))
      // layout.show(filterFormView)
      // on context change, translationList.fetch
      // on translationList select one,
      //   layout.show(translationEditView)
      //   + layout.show(translationHistoryView) + other tabs
      //   + layout.show(translationActionBar)
      //   + layout.show(translationEditTabs)
      // select next ???? event?
    },

    destroy: function() {
    },

    _renderLayout: function() {
    }
  });
});
