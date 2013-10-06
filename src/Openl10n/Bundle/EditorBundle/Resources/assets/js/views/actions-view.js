;(function(win, doc, editor) {

  editor.views.ActionsView = Backbone.Marionette.ItemView.extend({
    template: '#actions-template',

    ui: {
      undo: '.action-undo',
      skip: '.action-skip',
      copy: '.action-copy',
      save: '.action-save',
      approve: '.action-approve',
      unapprove: '.action-unapprove',
    },

    initialize: function () {
      this.listenTo(this.model, 'change', this.render);
    },

    onRender: function() {
      var _this = this;

      this.ui.copy.on('click', function() {
        var sourcePhrase = _this.model.get('source_phrase');
        _this.model.set('target_phrase', sourcePhrase);
      });

      this.ui.save.on('click', function() {
        _this.model.set('is_translated', true);
        _this.model.save();
      });

      this.ui.approve.on('click', function() {
        _this.model.set('is_approved', true);
        _this.model.save();
      });
      this.ui.unapprove.on('click', function() {
        _this.model.set('is_approved', false);
        _this.model.save();
      });
    }

  });

})(window, window.document, window.editor)
