;(function(win, doc, editor) {

  editor.views.HeaderView = Backbone.Marionette.ItemView.extend({
    template: '#header-template',

    ui: {
      domainList: 'ul.domain-list li a',
      selectSource: 'select.source-locale',
      selectTarget: 'select.target-locale',
    },

    onRender: function() {
      var _this = this;

      _this.ui.selectSource.val(editor.page.get('source'));
      _this.ui.selectTarget.val(editor.page.get('target'));

      editor.page.on('change:source', function() {
        _this.ui.selectSource.val(editor.page.get('source'));
      })

      editor.page.on('change:target', function() {
        _this.ui.selectTarget.val(editor.page.get('target'));
      })

      this.ui.selectSource.on('change', function() {
        editor.page.set('source', $(this).val());
      });

      this.ui.selectTarget.on('change', function() {
        editor.page.set('target', $(this).val());
      });

      this.ui.domainList.on('click', function(evt) {
        evt.preventDefault();
        editor.page.set('domain', $(this).data('slug'));
      });
    },

    serializeData: function(){
      return {
        domain: editor.page.get('domain')
      };
    }

  });

})(window, window.document, window.editor)
