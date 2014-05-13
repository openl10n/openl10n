define(['app', 'apps/editor/translate/views'], function(app, View) {
  return function(projectSlug, source, target) {
    //console.log('do translation of ' + projectSlug + ', in ' + source + ' to ' + target);

    var layout = new View.Layout();
    app.mainRegion.show(layout);

    var headerView = new View.Header();
    layout.headerRegion.show(headerView);

    var actionBarView = new View.ActionBar();
    layout.actionBarRegion.show(actionBarView);

    var filtersView = new View.Filters();
    layout.filtersRegion.show(filtersView);

    var translationListView = new View.TranslationList();
    layout.translationListRegion.show(translationListView);

    var translationEditView = new View.TranslationEdit();
    layout.translationEditRegion.show(translationEditView);
  }
});
