<div class="ol-editor-header-inner">
  <div class="pull-left">
    <div class="ol-editor-header-title">
      <a class="project-name" href="projects/<%- project.slug %>">
        <%- project.name %>
      </a>

      <div class="ol-editor-domain-list dropdown">
        <!-- <a data-toggle="dropdown"> -->
          <span class="domain-name">
            All phrases
          </span>
          <!-- <i class="fa fa-caret-down"></i> -->
        <!-- </a> -->

        <!-- <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
          <li>
            <a href="#" data-id="*">
              <span class="domain-name">
                All Phrases
              </span>
            </a>
          </li>

          <% _.each(resources, function(resource) { %>
            <li>
              <a href="#" data-id="*">
                <span class="domain-name">
                  All Phrases
                </span>
              </a>
            </li>
          <% }); %>
        </ul> -->
      </div>
    </div>
  </div>

  <div class="pull-right">
    <div class="ol-editor-header-item ol-editor-header-item-form">
      <select class="form-control source-locale">
        <option disabled selected>Source Locale</option>
        <% _.each(languages, function(language) { %>
          <option value="<%- language.locale %>" <% if (language.locale === context.source) { %>selected<% }%>>
            <%- language.name %> (<%- language.locale %>)
          </option>
        <% }); %>
      </select>
    </div>

    <div class="ol-editor-header-item ol-editor-header-item-text">
      <p>
        <i class="fa fa-arrow-right"></i>
      </p>
    </div>

    <div class="ol-editor-header-item ol-editor-header-item-form">
      <select class="form-control target-locale">
        <option disabled selected>Target Locale</option>
        <% _.each(languages, function(language) { %>
          <option value="<%- language.locale %>" <% if (language.locale === context.target) { %>selected<% }%>>
            <%- language.name %> (<%- language.locale %>)
          </option>
        <% }); %>
      </select>
    </div>
  </div>

  <div class="clearfix"></div>
</div>
