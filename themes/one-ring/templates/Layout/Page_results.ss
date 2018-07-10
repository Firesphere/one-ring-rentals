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
                                $Content.Summary
                            </article>
                        <% end_loop %>
                    </div>
                <% end_if %>
            </div>

            <div class="sidebar gray col-sm-4">
                <% if $Facets %>
                    <h2 class="section-title">Regions</h2>
                    <ul class="categories subnav">
                        <% loop $Facets.Region %>
                            <li><a class="$LinkingMode" href="$Top.Link?search=$Top.Query&{$ClassName}[]={$ID}">$Title ($FacetCount)</a></li>
                        <% end_loop %>
                    </ul>
                <% end_if %>
            </div>
            				<!-- BEGIN PAGINATION -->
				<% if $Results.MoreThanOnePage %>
				<div class="pagination">
					<% if $Results.NotFirstPage %>
					<ul id="previous col-xs-6">
						<li><a href="$Results.PrevLink"><i class="fa fa-chevron-left"></i></a></li>
					</ul>
					<% end_if %>
					<ul class="hidden-xs">
						<% loop $Results.PaginationSummary %>
							<% if $Link %>
								<li <% if $CurrentBool %>class="active"<% end_if %>>
									<a href="$Link">$PageNum</a>
								</li>
							<% else %>
								<li>...</li>
							<% end_if %>
						<% end_loop %>
					</ul>
					<% if $Results.NotLastPage %>
					<ul id="next col-xs-6">
						<li><a href="$Results.NextLink"><i class="fa fa-chevron-right"></i></a></li>
					</ul>
					<% end_if %>
				</div>
				<% end_if %>
				<!-- END PAGINATION -->
        </div>
    </div>
</div>
<!-- END CONTENT -->
