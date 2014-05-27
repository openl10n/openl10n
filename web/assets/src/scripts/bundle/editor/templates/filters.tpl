<form action="fkjsbdf">
  <i class="fa fa-search"></i>
  <% if (text) { %>
  <a href="#" data-bypass>
    <i class="clear">&times;</i>
  </a>
  <% } %>
  <input type="text" class="search-input input-lg" placeholder="Search…" value="<%- text %>">
</form>
