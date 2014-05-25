<select class="form-control">
  <option value=""></option>
  <% _.each(languagesList, function(language) { %>
    <option value="<%- language.locale %>" <% if (currentValue === language.locale) { %>selected<% } %>>
      <%- language.name %>
    </option>
  <% }); %>
</select>
