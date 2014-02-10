;(function(win, doc, Editor) {

  Editor.Views.FilterView = Backbone.Marionette.ItemView.extend({
    template: '#ol-editor-filter-template',

    timeoutId: null,

    ui: {
      input: 'input[type="text"]',
    },

    onRender: function() {
      var _this = this;

      this.ui.input.on('keyup', function() {
        if (_this.timeoutId)
          clearTimeout(_this.timeoutId);

        var text = $(this).val();

        _this.timeoutId = setTimeout(function() {
          if (text.length == 0)
            Editor.context.set('text', null);
          else if (text.length < 3)
            return;
          else
            Editor.context.set('text', text);
        }, 200);
      });
    }

  });

})(window, window.document, window.Editor)
