$(function () {
  //
  // UI
  //

  // Tooltip
  $('[data-toggle="tooltip"]').tooltip();

  // Select inputs
  //$('select').selectize();

  // Fullheight
  var $div = $('.fullheight');
  var $window = $(window);
  function updateEditorHeight() {
    if ($div.length < 1) return;
    var height = $window.height() - $div.offset().top;
    $div.height(height);
  }

  updateEditorHeight();
  $(window).resize(updateEditorHeight);

  // Slugify
  $(document).on('keyup', '.js-slugify', function() {
    var $this = $(this);
    if (!$this.data('slug')) return;

    var slug = S($this.val()).slugify().s;
    var $target = $('#' + $this.data('slug'));
    $target.val(slug);
  });

  // File slugify
  $(document).on('change', '.js-file-slugify', function() {
    var $this = $(this);

    var filename = $(this).val().split('/').pop().split('\\').pop();
    var matches = filename.match(/^(.*)\.([\w\-]+)\.(\w+)$/);
    if (null === matches) return;

    var slug = S(matches[1]).slugify().s;
    var locale = matches[2].replace('-', '_');

    $('#' + $this.data('slug')).val(slug);
    $('#' + $this.data('locale')).val(locale);
  });
});
