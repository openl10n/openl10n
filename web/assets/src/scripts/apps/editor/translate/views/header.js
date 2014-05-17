define([
  'marionette',
  'app',
  'tpl!apps/editor/translate/templates/header',
], function(Marionette, app, headerTpl) {

  return Marionette.ItemView.extend({
    template: headerTpl,

    ui: {
      selectSource: 'select.source-locale',
      selectTarget: 'select.target-locale',
    },

    initialize: function() {
      var _this = this;

      this.listenTo(this.model.get('context'), 'change:source', function() {
        _this.ui.selectSource.val(this.model.get('context').get('source'));
      });

      this.listenTo(this.model.get('context'), 'change:target', function() {
        _this.ui.selectTarget.val(this.model.get('context').get('target'));
      });
    },

    onRender: function() {
      var _this = this;

      _this.ui.selectSource.on('change', function() {
        app.trigger('editor:source', $(this).val());
      });

      _this.ui.selectTarget.on('change', function() {
        app.trigger('editor:target', $(this).val());
      });

      return;

      this.ui.selectSource.val(this.context.get('source_locale'));
      this.ui.selectTarget.val(this.context.get('target_locale'));

      _this.ui.selectTarget.on('change', function() {
        _this.context.set('target_locale', _this.ui.selectTarget.val());
      });

      this.context.on('change:source_locale', function() {
        _this.ui.selectSource.val(_this.context.get('source_locale'));
      });

      this.context.on('change:target_locale', function() {
        _this.ui.selectTarget.val(_this.context.get('target_locale'));
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

  });

});
