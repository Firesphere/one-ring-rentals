<% include Banner %>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="main col-sm-8">
                $Form
                <% if $Results %>
                    <div class="results">
                        <% loop $Results %>
                            <article class="result" data-highlight="$Up.Query.ATT">
                                <header>
                                    <h1 class="h3">
                                        <a href="$Link" title="$Title">$Title</a>
                                    </h1>
                                </header>
                                $Content.Summary.RAW
                            </article>
                        <% end_loop %>
                    </div>
                <% end_if %>
            </div>

            <div class="sidebar gray col-sm-4">
                <% if $Menu(2) %>
                    <h2 class="section-title">In this section</h2>
                    <ul class="categories subnav">
                        <% loop $Menu(2) %>
                            <li><a class="$LinkingMode" href="$Link">$MenuTitle</a></li>
                        <% end_loop %>
                    </ul>
                <% end_if %>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->
