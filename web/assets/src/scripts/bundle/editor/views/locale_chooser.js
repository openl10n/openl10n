define([
  'marionette',
  'tpl!bundle/editor/templates/locale_chooser'
], function(Marionette, localeChooserTpl) {

  return Marionette.ItemView.extend({
    template: localeChooserTpl,
    tagName: 'span',

    ui: {
      select: 'select'
    },

    initialize: function(options) {
      this.contextAttribute = options.contextAttribute;
      this.context = options.context;
      this.languagesList = options.languagesList;

      this.listenTo(this.languagesList, 'add', this.render);
      this.listenTo(this.languagesList, 'reset', this.render);
      this.listenTo(this.context, 'change', this.render);
    },

    onRender: function() {
      var _this = this;

      // Init extra events
      this.ui.select.on('change', function() {
        _this.context.set(
          _this.contextAttribute,
          _this.ui.select.val()
        );
      });
    },

    serializeData: function() {
      return {
        languagesList: this.languagesList.toJSON(),
        currentValue: this.context.get(this.contextAttribute)
      }
    }
  });

});
