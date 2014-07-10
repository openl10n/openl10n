var Marionette = require('backbone.marionette');

module.exports = Marionette.ItemView.extend({
  template: require('../templates/locale-chooser'),
  tagName: 'span',

  ui: {
    select: 'select'
  },

  events: {
    'change @ui.select': 'updateModel'
  },

  initialize: function(options) {
    // Language list
    this.collection = options.collection;

    // Context
    this.modelAttribute = options.modelAttribute;
    this.model = options.model;

    // Custom event
    this.listenTo(this.model, 'change:' + this.modelAttribute, this.updateUI);
  },

  onRender: function() {
    // After view has been rendered, call updateUI to be sure the correct
    // option is selected if model is initied with a non empty value.
    this.updateUI();
  },

  updateUI: function() {
    this.ui.select.val(
      this.model.get(this.modelAttribute)
    );
  },

  updateModel: function() {
    this.model.set(
      this.modelAttribute,
      this.ui.select.val()
    );
  },

  // onRender: function() {
  //   var _this = this;

  //   // Init extra events
  //   this.ui.select.on('change', function() {
  //     _this.model.set(
  //       _this.contextAttribute,
  //       _this.ui.select.val()
  //     );
  //   });
  // },

  serializeData: function() {
    return {
      languages: this.collection.toJSON(),
    }
  }
});
