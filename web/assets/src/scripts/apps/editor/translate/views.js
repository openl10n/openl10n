define([
  'apps/editor/translate/views/layout',
  'apps/editor/translate/views/actionbar',
  'apps/editor/translate/views/filters',
  'apps/editor/translate/views/header',
  'apps/editor/translate/views/translation_edit',
  'apps/editor/translate/views/translation_list',
], function(Layout, ActionBar, Filters, Header, TranslationEdit, TranslationList) {

  return {
    Layout: Layout,
    Header: Header,
    ActionBar: ActionBar,
    Filters: Filters,
    TranslationEdit: TranslationEdit,
    TranslationList: TranslationList,
  }

});
