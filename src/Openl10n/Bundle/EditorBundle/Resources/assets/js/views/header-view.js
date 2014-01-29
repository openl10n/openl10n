;(function(win, doc, Editor) {

  Editor.Views.HeaderView = Backbone.Marionette.ItemView.extend({
    template: '#ol-editor-template-header',

    ui: {
      domainList: '.ol-editor-domain-list li a[data-id]',
      selectSource: 'select.source-locale',
      selectTarget: 'select.target-locale',
    },

    initialize: function () {
      this.listenTo(Editor.context, 'change:domain', this.render);
      this.listenTo(Editor.context, 'change:source', this.render);
      this.listenTo(Editor.context, 'change:target', this.render);
    },

    updateSelectTarget: function() {
      this.ui.selectTarget.val(Editor.context.get('target'));
    },

    onRender: function() {
      var _this = this;

      console.log('[DEBUG] HeaderView onRender');

      this.ui.domainList.on('click', function(evt) {
        evt.preventDefault();

        var domain = $(this).data('id');
        Editor.context.set({
          'domain': domain,
          'hash': null
        });
      });

      this.ui.selectTarget.on('change', function() {
        var target = $(this).val();
        Editor.context.set('target', target);
      });

      this.ui.selectSource.on('change', function() {
        var source = $(this).val();
        Editor.context.set('source', source);
      });
    },

    serializeData: function() {
      var context = {
        target: Editor.context.get('target'),
        source: Editor.context.get('source'),
        domain: Editor.domains.get(Editor.context.get('domain')) ?
          Editor.domains.get(Editor.context.get('domain')).toJSON() : null,
      };

      return {
        project: Editor.project.toJSON(),
        domains: Editor.domains.toJSON(),
        languages: Editor.languages.toJSON(),
        context: context,
      };
    }

  });

})(window, window.document, window.Editor)
