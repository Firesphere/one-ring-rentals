<% include Banner %>
<div class="content">
	<div class="container">
		<div class="row">
			<div class="main col-sm-8">						
				<% with $Item %>
					<div class="blog-main-image">
						$PrimaryPhoto.SetWidth(750)
					</div>
					<p>$Description</p>
				<% end_with %>
			</div>
			
			<div class="sidebar gray col-sm-4">
				<h2 class="section-title">Properties</h2>
				<ul class="categories subnav">
					<% loop $Properties %>
						<li class="$LinkingMode">
							<a class="$LinkingMode" href="$Link">$Title</a>
						</li>
					<% end_loop %>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- END CONTENT -->
