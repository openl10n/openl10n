<div class="btn-group pull-right">
  <% if (is_approved && !edited) { %>
    <button class="btn btn-lg btn-default text-danger action-unapprove" <% if (!is_translated || edited) { %>disabled<% } %>>
      Unapprove
    </button>
  <% } else if (is_translated && !edited) { %>
    <button class="btn btn-lg btn-default text-success action-approve" <% if (!is_translated || edited) { %>disabled<% } %>>
      Approve
    </button>
  <% } else if (edited) { %>
    <button class="btn btn-lg btn-default text-default action-cancel">
      Cancel
    </button>
  <% } else { %>
    <button class="btn btn-lg btn-default text-default" disabled>
      Not translated
    </button>
  <% } %>
  <button class="btn btn-lg btn-wide btn-success action-save <% if (!edited) { %>disabled<% } %>">
    Save
  </button>
</div>
