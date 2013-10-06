/**
 * Definition of elements we'll use
 */
;(function(win, doc, editor) {

  // Classes
  editor.models = {};
  editor.views = {};

  // Instances
  editor.app = null;
  editor.router = null;
  editor.controller = null;
  editor.layout = null;
  editor.page = null;

})(window, window.document, window.editor || (window.editor = {}))
