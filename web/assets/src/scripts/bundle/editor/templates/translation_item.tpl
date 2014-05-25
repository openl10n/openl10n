<span class="status <% if (is_approved) { %>status-approved<% } else if (is_translated) { %>status-translated<% } %>"></span>

<p class="key">
  <span class="text-<% if (is_translated) { %>success<% } else { %>danger<% } %>">
    <i class="fa <% if (is_approved) { %>fa-check<% } else { %>fa-circle<% } %>"></i>
  </span>

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
