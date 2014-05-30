<span class="status <% if (is_approved) { %>status-approved<% } else if (is_translated) { %>status-translated<% } %>"></span>

<p class="key">
  <% if (edited) { %>
    <i class="icon-edit text-success fa fa-pencil"></i>
  <% } else { %>
    <i class="icon-status text-<% if (is_translated) { %>success<% } else { %>danger<% } %> fa <% if (is_approved) { %>fa-check<% } else { %>fa-circle<% } %>"></i>
  <% } %>

  <span class="identifier">
    <%- key %>
  </span>
</p>

<% if (source_phrase) { %>
  <p class="extract text-default">
    <%- S(source_phrase).truncate(100, '…') %>
  </p>
<% } else { %>
  <p class="extract text-danger">
    <em>undefined</em>
  </p>
<% } %>
