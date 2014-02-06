/**
 * Page mediator
 */
;(function(win, doc, Editor) {

  Editor.Models.Context = Backbone.Model.extend({

    defaults: {
      domain: null,
      source: null,
      target: null,
      hash: null,

      text: null,
      translated: null,
      approved: null,
    },

    generatePath: function(params) {
      params = _.extend(this.toJSON(), params);

      var path = [];

      if (params.target) {
        path.push(params.target);
      } else {
        return path.join('/');
      }

      if (params.domain) {
        path.push(params.domain);
      } else {
        path.push('*');
      }

      if (params.hash) {
        path.push(params.hash);
      }

      return path.join('/');
    }

  });

})(window, window.document, window.Editor)
