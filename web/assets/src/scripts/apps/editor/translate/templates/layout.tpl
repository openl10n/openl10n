<div class="sidebar js-scrollable" id="sidebar">
  <div class="sidebar-menu">
    <a href="#" class="sidebar-menu--item project-special">
      <i class="item-icon fa fa-rocket"></i>

      <span class="item-name" id="project-title">My Project Name</span>
    </a>

    <a href="#" class="sidebar-menu--item">
      <i class="item-icon fa fa-file-text-o"></i>
      <span class="item-name">Resources</span>
    </a>

    <a href="#" class="sidebar-menu--item active editor-special">
      <i class="item-icon fa fa-language"></i>
      <span class="item-name">Translate</span>
    </a>

    <a href="#" class="sidebar-menu--item editor-special">
      <i class="item-icon fa fa-eye-slash"></i>
      <span class="item-name">Proofread</span>
    </a>

    <a href="#" class="sidebar-menu--item">
      <i class="item-icon fa fa-upload"></i>
      <span class="item-name">Releases</span>
    </a>

    <a href="#" class="sidebar-menu--item">
      <i class="item-icon fa fa-wrench"></i>
      <span class="item-name">Settings</span>
    </a>
  </div>
</div>

<div class="content">
  <div class="x-editor--header">
    <div class="pull-right x-editor--locales-chooser form-inline">
      <select name="source" class="form-control">
        <option value="en">English (en)</option>
        <option value="fr">French (fr)</option>
      </select>

      <span class="fa fa-chevron-right"></span>

      <select name="target" class="form-control">
        <option value="en">English (en)</option>
        <option value="fr" selected>French (fr)</option>
      </select>
    </div>

    <div class="x-editor--resources-list">
      <i class="fa fa-cube"></i>
      <span>All phrases</span>
      <i class="fa fa-angle-down"></i>
    </div>
  </div>

  <div class="x-editor--subheader">
    <div class="x-editor--filters">
      <i class="fa fa-search"></i>
      <input type="text" class="search-input input-lg" placeholder="Search…">
    </div>

    <div class="x-editor--actions pull-right">
      <div class="btn-group  pull-right">
        <button class="btn btn-lg btn-success" disabled>
          <i class="fa fa-thumbs-up"></i>
        </button>
        <button class="btn btn-lg btn-wide btn-success">
          Save
        </button>
      </div>
    </div>
  </div>

  <div class="inner">
    <div class="x-editor--translations-selection">
      <div id="translations-list" class="x-editor--translations-list js-scrollable">
        <ul class="list-unstyled">
          <li class="translations-item">
            <span class="status status-translated"></span>

            <p class="key">
              <i class="text-success fa fa-circle"></i>

              <span class="identifier">
                demo.key.demo.key.demo.key.demo.key.demo.key.demo.key.demo.key
              </span>
            </p>

            <p class="extract text-default">
              This is my source phrase which might by truncated.
              This is my source phrase which might by truncated.
            </p>

          </li>

          <li class="translations-item active">
            <span class="status status-approved"></span>

            <p class="key">
              <i class="text-success fa fa-check"></i>

              <span class="identifier">
                demo.key
              </span>
            </p>

            <p class="extract text-default">
              This is my source phrase which might by truncated.
              This is my source phrase which might by truncated.
            </p>
          </li>

          <li class="translations-item">
            <span class="status"></span>

            <p class="key">
              <i class="text-danger fa fa-circle"></i>

              <span class="identifier">
                demo.key
              </span>
            </p>

            <p class="extract text-default">
              This is my source phrase which might by truncated.
              This is my source phrase which might by truncated.
            </p>
          </li>
        </ul>
      </div>
    </div>

    <div id="translation-edit" class="x-editor--translation-edit js-scrollable">
      <div class="ol-editor-source-area">
        <div class="meta pull-right">
          <span class="text-success">
            <i class="fa fa-check"></i>
          </span>

          <span>demo.key</span>
          <!-- <span class="meta-domain">(basic)</span> -->
        </div>

        <h4 class="title">
          Original phrase
        </h4>

        <p class="phrase text-default">
          This is my source phrase which might by truncated. This is my source phrase which might by truncated.
        </p>
      </div>

      <div class="ol-editor-target-area">
        <textarea class="form-control phrase-editor" placeholder="Translate here…"></textarea>
      </div>

      <div class="x-editor--edit-tabs">
        <ul class="nav nav-tabs">
          <li class="active">
            <a href="#">
              <i class="fa fa-info-circle"></i>
              <span>Information</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-recycle"></i>
              <span>Historique</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-quote-right"></i>
              <span>Suggestions</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-comments"></i>
              <span>Commentaires</span>
            </a>
          </li>
        </ul>
      </div>

    </div>
  </div>
</div>
