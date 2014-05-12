define(['app', 'apps/editor/translate/views'], function(app, View) {
  return function(projectSlug, source, target) {
    console.log('do translation of ' + projectSlug + ', in ' + source + ' to ' + target);

    var layout = new View.Layout();
    app.mainRegion.show(layout);
  }
});
