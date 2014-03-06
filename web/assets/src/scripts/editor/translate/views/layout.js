define(['marionette'], function(Marionette) {
  var Layout = Backbone.Marionette.Layout.extend({
    //el: '#ol-editor-layout',

    // Regions
    regions: {
      header: '#ol-editor-header',
      translationList: '#ol-editor-translation-list',
      translationEdit: '#ol-editor-translation-edit',
      actions: '#ol-editor-actions',
      //filter: '#ol-editor-filter',
      filters: '#ol-editor-translation-list-filters',
    },

    initialize: function() {
      // All navigation that is relative should be passed through the navigate
      // method, to be processed by the router. If the link has a `data-bypass`
      // attribute, bypass the delegation completely.
      this.$el.on('click', 'a[href]:not([data-bypass])', function(evt) {
        return;

        // Get the absolute anchor href.
        // this.router.previousRoute = location.href;
        var href = {
          prop: $(this).prop("href"),
          attr: $(this).attr("href")
        };

        // Get the absolute root.
        var root = location.protocol + "//" + location.host;

        // Ensure the root is part of the anchor href, meaning it's relative.
        if (href.prop.slice(0, root.length) === root) {
          // Stop the default event to ensure the link will not cause a page
          // refresh.
          evt.preventDefault();
          // `Backbone.history.navigate` is sufficient for all Routers and will
          // trigger the correct events. The Router's internal `navigate` method
          // calls this anyways.  The fragment is sliced from the root.
          Backbone.history.navigate(href.attr, true);
        }
      });
    }
  });

  return Layout;
});
