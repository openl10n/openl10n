<div class="ol-editor-source-area">
  <div class="meta pull-right">
    <span class="text-success">
      <i class="icon-status text-<% if (is_translated) { %>success<% } else { %>danger<% } %> fa <% if (is_approved) { %>fa-check<% } else { %>fa-circle<% } %>"></i>
    </span>

    <span><%- key %></span>
    <!-- <span class="meta-domain">(basic)</span> -->
  </div>

  <h4 class="title">
    Original phrase

    <a href="#" class="action-copy" data-bypass>
      <i class="fa fa-copy"></i>
    </a>
  </h4>

  <p class="phrase text-default">
    <%- source_phrase %>
  </p>
</div>

<div class="ol-editor-target-area">
  <textarea class="form-control phrase-editor" placeholder="Translate here…"><%- target_phrase %></textarea>
  <p class="meta">
    <span class="info-characters pull-right">
      <!--
      Phrase length:
      <span class="phrase-length"><%- target_phrase.length %></span> /
      <span class="phrase-length-max">100</span>
      -->
    </span>
    <span class="info-tab">
      Press <strong>TAB</strong> to move to the next phrase
    </span>
  </p>
</div>
