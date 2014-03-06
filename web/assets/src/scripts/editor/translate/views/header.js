define(['marionette'], function(Marionette) {

  var HeaderView = Marionette.ItemView.extend({
    template: '#ol-editor-template-header',

    ui: {
      domainList: '.ol-editor-domain-list',
      selectSource: 'select.source-locale',
      selectTarget: 'select.target-locale',
    },

    initialize: function (options) {
      this.context = options.context;
      this.filterBag = options.filterBag;

      // this.listenTo(Editor.context, 'change:domain', this.render);
      // this.listenTo(Editor.context, 'change:source', this.render);
      // this.listenTo(Editor.context, 'change:target', this.render);
    },

    onRender: function() {
      var _this = this;

      _this.ui.selectSource.on('change', function() {
        _this.context.set('source_locale', _this.ui.selectSource.val());
      });
      _this.ui.selectTarget.on('change', function() {
        _this.context.set('target_locale', _this.ui.selectTarget.val());
      });

      this.context.on('change:source_locale', function() {
        _this.ui.selectSource.val(_this.context.get('source_locale'));
      });

      this.context.on('change:target_locale', function() {
        _this.ui.selectTarget.val(_this.context.get('target_locale'));
      });

      this.ui.domainList.on('click', 'li a[data-id]', function(evt) {
        evt.preventDefault();

        var $el = $(this);
        var domainSlug = $el.data('id');
        var domainName = $el.find('.domain-name').text();

        console.log(domainName);
        _this.ui.domainList.find('> a .domain-name').text(domainName);

        _this.filterBag.set({
          'domain': '*' != domainSlug ? domainSlug : null,
          'hash': null
        });
      });

      // this.ui.selectTarget.on('change', function() {
      //   var target = $(this).val();
      //   Editor.context.set('target', target);
      // });

      // this.ui.selectSource.on('change', function() {
      //   var source = $(this).val();
      //   Editor.context.set('source', source);
      // });
    },

    // serializeData: function() {
    //   var context = {
    //     target: Editor.context.get('target'),
    //     source: Editor.context.get('source'),
    //     domain: Editor.domains.get(Editor.context.get('domain')) ?
    //       Editor.domains.get(Editor.context.get('domain')).toJSON() : null,
    //   };

    //   return {
    //     project: Editor.project.toJSON(),
    //     domains: Editor.domains.toJSON(),
    //     languages: Editor.languages.toJSON(),
    //     context: context,
    //   };
    // }

  });

  return HeaderView;

});
