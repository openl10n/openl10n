<li>
  <a href="#" data-bypass class="filter-all <% if (filter == 'all') { %>active<% } %>">
    <span class="count"><%= stats.all %></span>
    <span class="name">All</span>
  </a>
</li>
<li>
  <a href="#" data-bypass class="filter-untranslated <% if (filter == 'untranslated') { %>active<% } %>">
    <span class="count"><%= stats.untranslated %></span>
    <span class="name">Untranslated</span>
  </a>
</li>
<li>
  <a href="#" data-bypass class="filter-unapproved <% if (filter == 'unapproved') { %>active<% } %>">
    <span class="count"><%= stats.unapproved %></span>
    <span class="name">Unapproved</span>
  </a>
</li>
