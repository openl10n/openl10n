var Marionette = require('backbone.marionette');
var msgbus = require('msgbus');

module.exports = Marionette.Controller.extend({
  translate: function(projectSlug, source, target, translationId, filters) {
    console.log('Translate ' + projectSlug);
  },

  proofread: function(projectSlug, source, target, translationId, filters) {
    console.log('Proofread ' + projectSlug);
  }
});
