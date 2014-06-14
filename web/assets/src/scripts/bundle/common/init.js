define([
  'marionette',
  'bundle/common/behavior/scrollable',
], function(Marionette, ScrollableBehavior) {

  // Define stored behaviors
  Marionette.Behaviors.behaviorsLookup = function() {
    return {
      Scrollable: ScrollableBehavior
    };
  }

});
