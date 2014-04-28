define(['domReady!', 'jquery', 'string'], function(doc, $, S) {

  // Tooltip
  $('[data-toggle="tooltip"]').tooltip();

  // Select inputs
  //$('select').selectize();

  // Fullheight
  var $window = $(window);
  function updateBlockHeight() {
    $('.fullheight').each(function() {
      var $this = $(this);
      var height = $window.height() - $this.offset().top;
      $this.height(height);
    });
  }
  updateBlockHeight();
  $(window).resize(updateBlockHeight);

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
