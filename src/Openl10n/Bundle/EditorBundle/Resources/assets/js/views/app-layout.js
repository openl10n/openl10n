;(function(win, doc, editor) {

  editor.views.AppLayout = Backbone.Marionette.Layout.extend({
    el: '#appLayout',

    // Regions
    regions: {
      header: '#header',
      translationList: '#translation-list',
      translationEdit: '#translation-edit',
      actions: '#actions',
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

})(window, window.document, window.editor)
