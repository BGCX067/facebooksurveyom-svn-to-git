
		<div id="restaurant_menu">
			<div class="left_column prefix_1 grid_5 alpha omega">
				<ul>
					<li><a href="#">Appetizer</a><li>
					<li><a href="#">Soups</a><li>
					<li><a href="#">Main Course</a><li>
					<li><a href="#">Light Meals</a><li>
					<li><a href="#">Appetizer</a><li>
					<li><a href="#">Soups</a><li>
					<li><a href="#">Main Course</a><li>
					<li><a href="#">Light Meals</a><li>
				</ul>
			</div>
			<div class="right_column prefix_1 grid_8">
				<h2>Appetizers</h2>
				<ul class="menu_list">
				
					<li class="menu_item">
						<ul>
							<li class="image">
								<div class="background">
									<a href="#">
										<span class="time_to_cook">80</span>
										<span class="cook_min">mins</span>
									</a>
								</div>
							</li>
							<li class="title"><h3><a href="#">Fruit Salad</a></h3></li>
							<li class="rating">
								<div id="star_rating_1"><p class="star_count">(5000)</p></div> 
								<script type="text/javascript">
									$('#star_rating_1').rater('<?php echo $absoluteURL?>includes/webfiles/star.rating.php?resto_id=test_id&menu_id=10', {style:'small', maxvalue:5, curvalue:3.5});
								</script>
							</li>
							<li class="description">
								<h6>Morbi sapien risus, volutpat nec ultricies non, volutpat sed lacus. Nulla at ligula eget sapien accumsan gravida quis vel leo. Sed porta viverra est mollis dictum [...]</h6>
							</li>
						</ul>
					</li>
									
					<li class="menu_item">
						<ul>
							<li class="image">
								<div class="background">
									<a href="#">
										<span class="time_to_cook">80</span>
										<span class="cook_min">mins</span>
									</a>
								</div>
							</li>
							<li class="title"><h3><a href="#">Fruit Salad</a></h3></li>
							<li class="rating">
								<div id="star_rating_2"><p class="star_count">(5000)</p></div> 
								<script type="text/javascript">
									$('#star_rating_2').rater('<?php echo $absoluteURL?>includes/webfiles/star.rating.php?resto_id=test_id&menu_id=10', {style:'small', maxvalue:5, curvalue:3.5});
								</script>
							</li>
							<li class="description">
								<h6>Morbi sapien risus, volutpat nec ultricies non, volutpat sed lacus. Nulla at ligula eget sapien accumsan gravida quis vel leo. Sed porta viverra est mollis dictum [...]</h6>
							</li>
						</ul>
					</li>
					
				</ul>
			</div>
			<ul class="pagination">
				<li class="previous"><a href="#">Previous</a>
				<li><a href="#">1</a>
				<li><a href="#">2</a>
				<li class="selected"><a href="#">3</a>
				<li><a href="#">4</a>
				<li><a href="#">5</a>
				<li class="next"><a href="#">Next</a>
			</ul>	
		</div>