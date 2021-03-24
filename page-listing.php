<?php
	get_header();
	//Template Name: services
?>
<?php
$keyword = '';
$city = 'All';
if(isset($_GET['keyword']) && !empty($_GET['keyword'])) {

    $keyword = $_GET['keyword'];

}

if(isset($_GET['city']) && !empty($_GET['city'])) {

    $city = $_GET['city'];

}

$urlQuery = array(

			'keyword' => $keyword,
			'city'	  => $city,
			);

$url   = 'https://staging.irishdirectory.ie/wp-json/v1/business/?'.
		  http_build_query($urlQuery);

$call  = wp_remote_get( $url, array( 'timeout' => 120) );

$businesses  = json_decode( wp_remote_retrieve_body( $call ));
//$list= array_merge($businesses->premiums,$businesses->defaults);
 if(!empty($businesses->premiums))
 {
 	$list= array_merge($businesses->premiums,$businesses->defaults);
 }
 else{
	 $list=$businesses->defaults;
 }
// foreach ($list as $key => $value) {
// 	$title=$value->post_title;
// 	$post=$value->post_name;
// 	$url=$value->guid;
// 	$post=$value->post_type;
// 	$content=$value->post_content;
// 	$city=$value->city;
// 	$contact=$value->contact;
// 	$rating=$value->rating;
//
// }
?>
<?php $themePath = get_stylesheet_directory_uri(); ?>

<section class="business-listing-area">
	<div class="container-fluid" style="padding: 0;">
		<div class="row without-map-row" style="margin: 0;">
			<div class="col-md-3 pl-0 custom-col-md-3">
				<div class="business-listing-filerts">
					<div class="business-listing-filerts-breadcrumb">
						<nav aria-label="breadcrumb">
						  <ol class="breadcrumb">
						    <li class="breadcrumb-item"><a href="#">Home</a></li>
						    <li class="breadcrumb-item active" aria-current="page">Search ‘Dublin’</li>
						  </ol>
						</nav>
					</div>
					<p class="results-found">23 results found for ‘Salon’ in ‘Dublin’</p>
					<div class="filter-button">
						<h5><img src="<?=$themePath;?>/images/filters.svg"> Filters</h5>
						<form class="most-popular-form">
							 <select class="form-control" id="exampleFormControlSelect1">
						      <option>The Most Popular</option>
						      <option>The Most Popular</option>
						    </select>
						</form>
					</div>
					<div class="filter-options-wrapper">
						<div class="filter-area">
							<button class="filter-heading">
								<h6>Suggested</h6> <img src="<?=$themePath;?>/images/chevrone-top.svg">
							</button>
							<div class="filter-options">
								<div class="input-wrap">
									<input type="checkbox" name="open-now" id="open-now" checked />
									<label for="open-now" class="filter-label checkbox-label">Open Now</label>
								</div>
							</div>
						</div>

						<div class="filter-area">
							<button class="filter-heading">
								<h6>Category</h6> <img src="<?=$themePath;?>/images/chevrone-top.svg">
							</button>
							<div class="filter-options">
								<div class="checkbox-pill-wrapper">
									<input type="checkbox" name="web-design" id="web-design" checked >
									<label for="web-design" class="filter-label checkbox-pill">Web Design</label>
								</div>
								<div class="checkbox-pill-wrapper">
									<input type="checkbox" name="marketing" id="marketing" checked >
									<label for="marketing" class="filter-label checkbox-pill">Marketing</label>
								</div>
								<div class="checkbox-pill-wrapper">
									<input type="checkbox" name="graphic-design" id="graphic-design">
									<label for="graphic-design" class="filter-label checkbox-pill">Graphic Design</label>
								</div>
								<div class="checkbox-pill-wrapper">
									<input type="checkbox" name="media" id="media">
									<label for="media" class="filter-label checkbox-pill">Media</label>
								</div>


								<div class="custom-accordion" id="filter-category-tags" style="display: none;">
								    <div class="checkbox-pill-wrapper">
										<input type="checkbox" name="content" id="content">
										<label for="content" class="filter-label checkbox-pill">Content</label>
									</div>
									<div class="checkbox-pill-wrapper">
										<input type="checkbox" name="logo-creation" id="logo-creation">
										<label for="logo-creation" class="filter-label checkbox-pill">Logo Creation</label>
									</div>
								</div>

								<p class="see-all-expend-btn">
									<a class="cusotm-accordion-control" href="javascript:void(0);" role="button" aria-expanded="false" aria-controls="filter-category-tags">See all</a>
								</p>
							</div>
						</div>

						<?php /*
						<div class="filter-area">
							<button class="filter-heading">
								<h6>City or County</h6> <img src="<?=$themePath;?>/images/chevrone-top.svg">
							</button>
							<div class="filter-options">
								<div class="input-wrap">
									<input type="input" placeholder="Search" class="input-search">
									<div class="search-pills-wraaper">
										<span class="search-pill">Dublin <span class="delete-search-pill">&times;</span></span>
									</div>
								</div>
								<div class="input-wrap">
									<input type="checkbox" name="current-location" id="current-location" />
									<label for="current-location" class="filter-label checkbox-label">Current Location</label>
								</div>
								<div class="input-wrap">
									<input type="checkbox" name="balrothery" id="balrothery" />
									<label for="balrothery" class="filter-label checkbox-label">Balrothery</label>
								</div>
								<div class="input-wrap">
									<input type="checkbox" name="ronanstown" id="ronanstown" />
									<label for="ronanstown" class="filter-label checkbox-label">Ronanstown</label>
								</div>
								<div class="input-wrap">
									<input type="checkbox" name="south-inner-city" id="south-inner-city" />
									<label for="south-inner-city" class="filter-label checkbox-label">South Inner City</label>
								</div>
							</div>
						</div>
						*/ ?>

						<div class="filter-area">
							<button class="filter-heading">
								<h6>Distance</h6> <img src="<?=$themePath;?>/images/chevrone-top.svg">
							</button>
							<div class="filter-options">
								<!-- add active class on select in input-wrap -->
								<div class="input-wrap active">
									<input type="radio" name="distance" id="5km" checked />
									<label for="5km" class="filter-label radio-label">Within 5 km</label>
								</div>
								<div class="input-wrap">
									<input type="radio" name="distance" id="10km" />
									<label for="10km" class="filter-label radio-label">Within 10 km</label>
								</div>
								<div class="input-wrap">
									<input type="radio" name="distance" id="20km" />
									<label for="20km" class="filter-label radio-label">Within 20 km</label>
								</div>
								<div class="input-wrap">
									<input type="radio" name="distance" id="40km" />
									<label for="40km" class="filter-label radio-label">Within 40 km</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9 px-0 custom-col-md-9">
				<div class="business-listing-with-map row">
					<div class="businesses-listing-sec with-map-column">
						<div class="businesses-listing-search-filter">
							<p class="results-found">23 results found for ‘Salon’ in ‘Dublin’</p>
							<div class="most-popular">
								<form class="most-popular-form">
								 <select class="form-control" id="exampleFormControlSelect1">
							      <option>The Most Popular</option>
							      <option>The Most Popular</option>
							    </select>
								</form>
								<div class="show-map">
									<a class="show-map-link" href="javascript:void(0)">Show Map <img src="<?=$themePath;?>/images/map-icon.svg"></a>
								</div>
							</div>
						</div>
						<div class="business-listing-wrapper full-width-575" style="display: none;">
							<div class="business-listing-box">
								<?php
								foreach ($list as $key => $value) {
									$title=$value->post_title;
									$post=$value->post_name;
									$url=$value->guid;
									$post=$value->post_type;
									$content=$value->post_content;
									$city=$value->city;
									$contact=$value->contact;
									$rating=$value->rating;
								 ?>
								<div class="business-listing-slider">
									<div class="business-listing-slide">
										<img src="<?=$themePath;?>/images/business-type-img.jpg">
									</div>
									<div class="business-listing-slide">
										<img src="<?=$themePath;?>/images/home-boys1.jpg">
									</div>
									<div class="business-listing-slide">
										<img src="<?=$themePath;?>/images/grace-wedding-web.jpg">
									</div>
								</div>
								<div class="wish-list-verified-icons">
									<span class="listing-wishlist-icon">
										<img src="<?=$themePath;?>/images/wish-list-icon-unfilled.svg">
									</span>
									<span class="listing-verified-icon">
										<p>Boosted</p>
										<img src="<?=$themePath;?>/images/verified-icon.svg">
									</span>
								</div>

								<div>
									<span>
									<h5 style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;display: inherit;"><a href="<?php echo $url;?>"><?php echo $title;?></a></h5>

										<i class="fa fa-rate"></i>
									<label>Rating: <?php echo $rating;?></label>
								</span><br/>
									<span>
									<label>City: <?php echo $city;?></label>
									</span>
									<span>
									<label>Contact: <?php echo $contact;?></label>
								</span><br/>
								<span>
								<p><?php echo $post;?></p>
							</span><br/>
								</div>
								<?php
								}
								?>								
							</div>	
						</div>
						<div class="business-listing-wrapper full-width-575">
							<div class="businesses-listing-box">
								<div class="business-listing-slider">
									<div class="business-listing-slide">
										<img src="<?=$themePath;?>/images/business-type-img.jpg">
									</div>
									<div class="business-listing-slide">
										<img src="<?=$themePath;?>/images/home-boys1.jpg">
									</div>
									<div class="business-listing-slide">
										<img src="<?=$themePath;?>/images/grace-wedding-web.jpg">
									</div>
								</div>
								<div class="wish-list-verified-icons">
									<span class="listing-wishlist-icon">
										<img src="<?=$themePath;?>/images/wish-list-icon-unfilled.svg">
									</span>
									<span class="listing-verified-icon">
										<p>Boosted</p>
										<img src="<?=$themePath;?>/images/verified-icon.svg">
									</span>
								</div>
								<div class="contact-icons">
									<span class="contact-logo-icon">
										<a href="javascript:void(0)"><img src="<?=$themePath;?>/images/irish-small-icon.svg"></a>
									</span>
									<div class="contact-icon-wrapper">
										<span class="contact-chat-icon">
											<a href="javascript:void(0)"><img src="<?=$themePath;?>/images/chat-icon.svg"></a>
										</span>
										<span class="contact-phone-icon">
											<a href="javascript:void(0)"><img src="<?=$themePath;?>/images/phone-medium-icon.svg"></a>
										</span>								
									</div>							
								</div>
								<div class="business-listing-content">
									<div class="business-listing-heading">
										<h3>Sarah’s Jewels</h3>
										<span class="business-ratings"><img src="<?=$themePath;?>/images/active-icon.svg"> 4.6(1.9)</span>
										<span class="business-open-status">Open 24/7</span>
									</div>
									<div class="business-location-contact">
										<span class="business-location"><a href="javascript:void(0)"><img src="<?=$themePath;?>/images/location-icon.svg"> Dublin</a></span>
										<span class="business-display-contact"><a href="javascript:void(0)"><img src="<?=$themePath;?>/images/phone-icon.svg">Display Contact</a></span>			
									</div>
									<div class="businesses-website-tags">
										<p><a href="javascript:void(0)">Website Design</a>, <a href="javascript:void(0)">Information Technology</a> <span class="tags-count">+5</span></p>
										<div class="contact-chat-phone-icons">
											<span class="contact-chat-icon">
												<a href="javascript:void(0)"><img src="<?=$themePath;?>/images/circle-star-icon.svg"></a>
											</span>
											<span class="contact-phone-icon">
												<a href="javascript:void(0)"><img src="<?=$themePath;?>/images/dimond-icon.svg"></a>
											</span>									
										</div>
									</div>								
								</div>
							</div>
						</div>
						<div class="business-listing-wrapper full-width-575">
							<div class="businesses-listing-box">
								<div class="business-listing-slider">
									<div class="business-listing-slide">
										<img src="<?=$themePath;?>/images/business-type-img.jpg">
									</div>
									<div class="business-listing-slide">
										<img src="<?=$themePath;?>/images/home-boys1.jpg">
									</div>
									<div class="business-listing-slide">
										<img src="<?=$themePath;?>/images/grace-wedding-web.jpg">
									</div>
								</div>
								<div class="wish-list-verified-icons">
									<span class="listing-wishlist-icon">
										<img src="<?=$themePath;?>/images/wish-list-icon-unfilled.svg">
									</span>
									<span class="listing-verified-icon">
										<p>Boosted</p>
										<img src="<?=$themePath;?>/images/verified-icon.svg">
									</span>
								</div>
								<div class="contact-icons">
									<span class="contact-logo-icon">
										<a href="javascript:void(0)"><img src="<?=$themePath;?>/images/irish-small-icon.svg"></a>
									</span>
									<div class="contact-icon-wrapper">
										<span class="contact-chat-icon">
											<a href="javascript:void(0)"><img src="<?=$themePath;?>/images/chat-icon.svg"></a>
										</span>
										<span class="contact-phone-icon">
											<a href="javascript:void(0)"><img src="<?=$themePath;?>/images/phone-medium-icon.svg"></a>
										</span>								
									</div>							
								</div>
								<div class="business-listing-content">
									<div class="business-listing-heading">
										<h3>Sarah’s Jewels</h3>
										<span class="business-ratings"><img src="<?=$themePath;?>/images/active-icon.svg"> 4.6(1.9)</span>
										<span class="business-open-status">Open 24/7</span>
									</div>
									<div class="business-location-contact">
										<span class="business-location"><a href="javascript:void(0)"><img src="<?=$themePath;?>/images/location-icon.svg"> Dublin</a></span>
										<span class="business-display-contact"><a href="javascript:void(0)"><img src="<?=$themePath;?>/images/phone-icon.svg">Display Contact</a></span>			
									</div>
									<div class="businesses-website-tags">
										<p><a href="javascript:void(0)">Website Design</a>, <a href="javascript:void(0)">Information Technology</a> <span class="tags-count">+5</span></p>
										<div class="contact-chat-phone-icons">
											<span class="contact-chat-icon">
												<a href="javascript:void(0)"><img src="<?=$themePath;?>/images/circle-star-icon.svg"></a>
											</span>
											<span class="contact-phone-icon">
												<a href="javascript:void(0)"><img src="<?=$themePath;?>/images/dimond-icon.svg"></a>
											</span>									
										</div>
									</div>								
								</div>
							</div>
						</div>
						<div class="business-listing-wrapper full-width-575">
							<div class="businesses-listing-box">
								<div class="business-listing-slider">
									<div class="business-listing-slide">
										<img src="<?=$themePath;?>/images/business-type-img.jpg">
									</div>
									<div class="business-listing-slide">
										<img src="<?=$themePath;?>/images/home-boys1.jpg">
									</div>
									<div class="business-listing-slide">
										<img src="<?=$themePath;?>/images/grace-wedding-web.jpg">
									</div>
								</div>
								<div class="wish-list-verified-icons">
									<span class="listing-wishlist-icon">
										<img src="<?=$themePath;?>/images/wish-list-icon-unfilled.svg">
									</span>
									<span class="listing-verified-icon">
										<p>Boosted</p>
										<img src="<?=$themePath;?>/images/verified-icon.svg">
									</span>
								</div>
								<div class="contact-icons">
									<span class="contact-logo-icon">
										<a href="javascript:void(0)"><img src="<?=$themePath;?>/images/irish-small-icon.svg"></a>
									</span>
									<div class="contact-icon-wrapper">
										<span class="contact-chat-icon">
											<a href="javascript:void(0)"><img src="<?=$themePath;?>/images/chat-icon.svg"></a>
										</span>
										<span class="contact-phone-icon">
											<a href="javascript:void(0)"><img src="<?=$themePath;?>/images/phone-medium-icon.svg"></a>
										</span>								
									</div>							
								</div>
								<div class="business-listing-content">
									<div class="business-listing-heading">
										<h3>Sarah’s Jewels</h3>
										<span class="business-ratings"><img src="<?=$themePath;?>/images/active-icon.svg"> 4.6(1.9)</span>
										<span class="business-open-status">Open 24/7</span>
									</div>
									<div class="business-location-contact">
										<span class="business-location"><a href="javascript:void(0)"><img src="<?=$themePath;?>/images/location-icon.svg"> Dublin</a></span>
										<span class="business-display-contact"><a href="javascript:void(0)"><img src="<?=$themePath;?>/images/phone-icon.svg">Display Contact</a></span>			
									</div>
									<div class="businesses-website-tags">
										<p><a href="javascript:void(0)">Website Design</a>, <a href="javascript:void(0)">Information Technology</a> <span class="tags-count">+5</span></p>
										<div class="contact-chat-phone-icons">
											<span class="contact-chat-icon">
												<a href="javascript:void(0)"><img src="<?=$themePath;?>/images/circle-star-icon.svg"></a>
											</span>
											<span class="contact-phone-icon">
												<a href="javascript:void(0)"><img src="<?=$themePath;?>/images/dimond-icon.svg"></a>
											</span>									
										</div>
									</div>								
								</div>
							</div>
						</div>

						<div class="businesses-pagination">
							<ul class="pagination pagination-style">
							  <li class="page-item"><a class="page-link" href="#"><img src="<?=$themePath;?>/images/left-arrow-pagination.svg"> Previous</a></li>
							  <li class="page-item active"><a class="page-link" href="#">1</a></li>
							  <li class="page-item"><a class="page-link" href="#">2</a></li>
							  <li class="page-item"><a class="page-link" href="#">3</a></li>
							  <li class="page-item"><a class="page-link" href="#">4</a></li>
							  <li class="page-item"><a class="page-link" href="#">5</a></li>
							  <li class="page-item"><a class="page-link" href="#">6</a></li>
							  <li class="page-item"><a class="page-link" href="#">7</a></li>
							  <li class="page-item"><a class="page-link" href="#">8</a></li>
							  <li class="page-item"><a class="page-link" href="#">9</a></li>							  <li class="page-item"><a class="page-link" href="#">10</a></li>
							  <li class="page-item"><a class="page-link" href="#">....34</a></li>	  
							  <li class="page-item"><a class="page-link" href="#">Next <img src="<?=$themePath;?>/images/right-arrow-pagination.svg"></a></li>
							</ul>
						</div>
						<div class="cant-find-the-business">
							<div class="cant-find-the-business-content">
								<h3>Can't find the business?</h3>
								<p>Adding a business to IrishDirectory is always free.</p>
							</div>
							<div class="cant-find-the-business-btn">
								<a href="javascript:void(0)" class="btn-style btn-orange"> Register your Business</a>
							</div>					
						</div>
					</div>
					<div class="businesses-listing-map-sec without-map-column">
						<div class="map-section">
							<iframe src="https://www.google.com/maps/d/embed?mid=1oJFDzbsaJiuUBqLvEKChBCW0S7o&hl=en" width="100%" height="790"></iframe>
						</div>
						<div class="map-section-content">
							<div class="map-section-top-bar">
								<span class="cancel-btn"><img src="<?=$themePath;?>/images/cross-icon.png" /></span>
								<div class="search-as-map">
									<div class="input-wrap">
										<input type="checkbox" name="search-as" id="search-as" checked="">
										<label for="search-as" class="filter-label checkbox-label">Search as map moves</label>
									</div>
								</div>
							</div>
							<div class="map-section-bottom">
								
							</div>
						</div>
					</div>														
				</div>
			</div>
		</div>

	</div>

</section>

<section>
	<div class="container">
		<div class="row">
			<div class="col-md-9 popular-business text-center col-center">
				<?php

					// echo "Premium Businesses Count ".count($businesses->premiums)."<br>";
					//
					// echo "Default Businesses Count ".count($businesses->defaults)."<br>";
					// echo "Total Pages -".$businesses->total_pages."<br>";
					// echo "Total Found Post -".$businesses->total_found_posts."<br>";
					// echo "Post From -".$businesses->post_from."<br>";
					// echo "Post To -".$businesses->post_to."<br>";
					// echo "Current Page -".$businesses->current_page."<br>";
					// echo "Formatted From To -".$businesses->formatted_from_to."<br>";

				?>
			</div>
		</div>
	</div>
</section>

<div class="modal fade search-category-modal" id="search-category-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">Select Categories</h3>
			<button type="button" class="close list-business-modal-close" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
      </div>
      <div class="modal-body">
       	<div class="search-categories">
       		<form>
       			 <select class="form-control" id="exampleFormControlSelect1">
			      <option>Search Categories</option>
			    </select>
			    <ul class="categories-list">
			    	<li class="badge badge-primary alert-dismissible fade show">
			    		Graphic Design
			    		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
  					</li>
			    </ul>
			    <h4>Our Most Popular Categories</h4>
			    <ul class="most-popular-categories">
			    	<li>
	    				<div class="checkbox-pill-wrapper">
							<input type="checkbox" name="restaurants" id="restaurants" checked >
							<label for="restaurants" class="filter-label checkbox-pill"><img src="<?=$themePath;?>/images/restraunt-icon.svg"> Restaurants</label>
						</div>
			    	</li>
			    	<li>
	    				<div class="checkbox-pill-wrapper">
							<input type="checkbox" name="webdesign" id="webdesign">
							<label for="webdesign" class="filter-label checkbox-pill"><img src="<?=$themePath;?>/images/webdesign-icon.svg"> Web Design</label>
						</div>
			    	</li>
			    	<li>
	    				<div class="checkbox-pill-wrapper">
							<input type="checkbox" name="business" id="business">
							<label for="business" class="filter-label checkbox-pill"><img src="<?=$themePath;?>/images/business-icon.svg"> Business</label>
						</div>
			    	</li>
			    	<li>
	    				<div class="checkbox-pill-wrapper">
							<input type="checkbox" name="home-improvements" id="home-improvements">
							<label for="home-improvements" class="filter-label checkbox-pill"><img src="<?=$themePath;?>/images/home-improvement-icon.svg"> Home Improvements</label>
						</div>
			    	</li>
			    	<li>
	    				<div class="checkbox-pill-wrapper">
							<input type="checkbox" name="vending-machines" id="vending-machines">
							<label for="vending-machines" class="filter-label checkbox-pill"><img src="<?=$themePath;?>/images/vending-machine-icon.svg"> Vending Machines</label>
						</div>
			    	</li>
			    	<li>
	    				<div class="checkbox-pill-wrapper">
							<input type="checkbox" name="beauty" id="beauty">
							<label for="beauty" class="filter-label checkbox-pill"><img src="<?=$themePath;?>/images/beauty-icon.svg"> Beauty</label>
						</div>
			    	</li>
			    	<li>
	    				<div class="checkbox-pill-wrapper">
							<input type="checkbox" name="interior-decorating" id="interior-decorating">
							<label for="interior-decorating" class="filter-label checkbox-pill"><img src="<?=$themePath;?>/images/interior-design-icon.svg"> Interior Decorating</label>
						</div>
			    	</li>
			    </ul>
			    <div class="apply-filter-btn-wrapper">
			    	<button type="button" class="btn-style btn-light-green apply-filter-btn" ><span class="filter-count">23</span> Apply Filters</button>
			    </div>
       		</form>
       	</div>
      </div>
    </div>
  </div>
</div>


<style>
	.business-listing-area{
		padding-top: 10px;
	}
	.business-listing-filerts {
	    text-align: left;
	    padding-left: 30px;
	    padding-right: 24px;
	}
	.filter-area {
    	padding: 16px 0px;
	    border-top: 1px solid #EEEEEF;
	}
	button.filter-heading {
	    background: transparent;
	    border-width: 0px;
	    width: 100%;
	    display: flex;
	    align-items: center;
	    justify-content: space-between;
	    padding: 0px;
	    margin-bottom: 15px;
	}
	button.filter-heading h6 {
	    padding-bottom: 0px;
	}
	.filter-button h5 {
		font-size: 16px;
		line-height: 22px;
	}
	.input-wrap {
		position: relative;
		line-height: 140%;
	    margin-bottom: 5px;
	}
	.filter-label {
		font-size: 14px;
		line-height: 20px;
		color: #2B273C;
		text-transform: capitalize;
		cursor: pointer;
	}
	input[type="checkbox"] {
		opacity: 0;
	}
	label.checkbox-label, label.radio-label {
	    padding-left: 10px;
	}
	label.checkbox-label:before {
	    content: '';
	    position: absolute;
	    width: 20px;
	    height: 20px;
	    margin-right: 7px;
	    background: #FBFBFB;
	    border: 1px solid #D9E1E7;
	    border-radius: 4px;
	    top: 0px;
	    left: 0px;
	    bottom: 0px;
	    margin: auto;
	}
	label.checkbox-label:after {
	    content: '';
	    position: absolute;
	    width: 20px;
	    height: 20px;
	    background: url(<?=$themePath;?>/images/checkbox-tick.svg);
	    background-repeat: no-repeat;
	    background-position: center;
	    left: 0px;
	    top: 0px;
	    bottom: 0px;
	    margin: auto;
	    opacity: 0;
	}
	label.radio-label:before {
	    content: '';
	    position: absolute;
	    width: 20px;
	    height: 20px;
	    background: #FBFBFB;
	    border: 1px solid #D9E1E7;
	    border-radius: 30px;
	    left: 0px;
	}
	label.radio-label:after {
	    content: '';
	    position: absolute;
	    width: 10px;
	    height: 10px;
	    background: #33475B;
	    border: 1px solid #9CAEBF;
	    border-radius: 4px;
	    margin: auto;
	    opacity: 0;
	}
	input[type="checkbox"]:checked + .checkbox-label:before {
	    border-color: #000;
	}
	input[type="checkbox"]:checked + .checkbox-label:after {
	    opacity: 1;
	}
	input[type="radio"]:checked + .radio-label:before {
	    border-color: #000;
	}
	input[type="radio"]:checked + .radio-label:after {
	    opacity: 1;
	}
	label.checkbox-pill {
		text-transform: capitalize;
	    background: #FFFFFF;
	    border: 1px solid #ECECEC;
	    box-sizing: border-box;
	    border-radius: 16px;
	    display: inline-flex;
	    align-items: center;
	    justify-content: center;
	    padding: 5px 10px;
	    position: relative;
	    margin-right: 5px;
	    margin-bottom: 8px;
	    cursor: pointer;
	}
	.checkbox-pill-wrapper {
		position: relative;
		display: inline-block;
	}
	.checkbox-pill-wrapper input[type="checkbox"] {
	    position: absolute;
	}
	.checkbox-pill-wrapper input[type="checkbox"]:checked + label {
	    border-color: #000;
	    background: #F9F9F9;
	    font-weight: 500;
	}
	.see-all-expend-btn a {
	    color: #FF3D00;
	    font-size: 14px;
	}
	.see-all-expend-btn a:hover {
		color: #2B273C;
	}
	input.input-search {
	    background: #F6F6F6;
	    border-radius: 10px;
	    border: 1px solid #eee;
	    width: 100%;
	    padding: 6px 15px;
	    margin-bottom: 15px;
	}
	input.input-search::placeholder {
	    color: #B9B9B9;
	}
	.search-pills-wraaper {
	    margin-bottom: 7px;
	}
	span.search-pill {
	    font-size: 12px;
	    line-height: 18px;
	    color: #2B273C;
	    text-transform: capitalize;
	    padding: 4px 7px;
	    background: #FFFFFF;
	    border: 1px solid #ECECEC;
	    box-sizing: border-box;
	    border-radius: 16px;
	    display: inline-flex;
	    align-items: center;
	    justify-content: space-between;
	    margin-right: 5px;
	    margin-bottom: 8px;
	}
	span.search-pill .delete-search-pill {
	    margin-left: 9px;
	    cursor: pointer;
	    font-size: 25px;
	    color: #C5C5C5;
	}
	span.search-pill .delete-search-pill:hover {
	    color: #2B273C;
	}
	.input-wrap.active {
	    background: #F9F9F9;
	    border: 1px solid #E9E9E9;
	    border-radius: 30px;
	}
	/*listing css*/
	/*listing slider css*/
	.business-listing-wrapper {
	    width: 50%;
		padding: 0 7px;
		margin-bottom: 14px;
		float: left;
	}
	.businesses-listing-sec.with-map-column{
		width: 85%;
	}
	.with-map-column .business-listing-wrapper{
		width: 33.3%;	
	}
	.without-map-column{
		display: none;
	}
	.businesses-listing-box{
	    background: #FFFFFF;
	    position: relative;
	    border-radius: 8px;
	    border: 1px solid #DFEAF3;
	    overflow: hidden;
	}
	.business-listing-slider.slick-slider {
	    padding-bottom: 0px;
	    margin-bottom: 0;
	}
	.business-listing-slide {
	    height: 167px;
	}
	.business-listing-slide img {
	    width: 100%;
	    height: 100%;
	    object-fit: cover;
	}
	.business-listing-slider .slick-arrow {
	    transform: scale(0.5);
	    top: 0px;
	    bottom: 0px;
	    margin: auto;
	}
	.business-listing-slider .slick-prev {
	    left: -5px;
	}
	.business-listing-slider .slick-next {
	    right: -5px;
	}
	/*dots css*/
	.business-listing-slider .slick-dots {
	    bottom: 22px;
	    width: 100%;
	    display: flex;
	    justify-content: center;
	}
	.business-listing-slider .slick-dots li {
	    margin: 0px 1.5px;
	}
	.business-listing-slider .slick-dots li, .business-listing-slider .slick-dots li button {
	    padding: 0px;
	    height: 8px;
	    width: 8px;
	}
	.business-listing-slider .slick-dots li button:before {
	    height: 100%;
	    width: 100%;
	    background: rgba(251,251,251,0.23);
	    border: 1px solid rgba(255,255,255,0.58);
	}
	.business-listing-slider .slick-dots li.slick-active button:before {
	    background: #fff;
	    border-color: #fff;
	}
	.business-listing-slider .slick-list.draggable {
	    filter: brightness(0.7);
	}

	/*listing other css*/
	.wish-list-verified-icons {
	    padding: 8px;
	    display: flex;
	    align-items: center;
	    justify-content: space-between;
	    position: absolute;
	    width: 100%;
	    top: 0px;
	}
	.wish-list-verified-icons span.listing-wishlist-icon {
	    line-height: 1;
	}
	.wish-list-verified-icons span {
	    cursor: pointer;
	}
	span.listing-verified-icon,
	.contact-icon-wrapper{
	    display: flex;
	}
	.listing-verified-icon p {
	    font-size: 12px;
	    color: #fff;
	    margin-right: 8px;
	}
	.contact-icons {
	    display: flex;
	    justify-content: space-between;
	    padding: 0 10px;
	    margin-top: -21px;
	}
	.contact-icons span {
	    box-sizing: border-box;
	    width: 43px;
	    height: 43px;
	    display: flex;
	    justify-content: center;
	    align-items: center;
	    z-index: 2;
	}
	.contact-icon-wrapper span:not(:first-child){
		margin-left: 6px;
	}
	.business-listing-heading h3 {
	    font-size: 16px;
	    color: #6A6A6A;
	    padding-bottom: 0;
        max-width: 111px;
	}
	.business-listing-heading {
	    display: flex;
	    align-items: center;
	    position: relative;
	}
	span.business-ratings {
	    font-size: 10px;
	    display: flex;
	    align-items: center;
	    margin-left: 5px;
	}
	.business-ratings img,
	.business-location-contact span img{
		padding-right: 5px;
		vertical-align: text-bottom;	
	}
	span.business-open-status {
	    font-size: 10px;
	    color: #61821E;
	    position: absolute;
	    right: 0;
	}
	.business-listing-content{
		padding: 5px 10px;
	}
	.business-location-contact span {
	    font-size: 12px;
	    display: flex;
	    align-items: center;
	    flex:0 0 50%;
	}
	.business-location-contact,
	.businesses-website-tags{
	    display: flex;
	    justify-content: space-between;
	}
	.businesses-website-tags p {
	    font-size: 10px;
	    display: flex;
	    align-items: center;
	    flex-wrap: wrap;
	}
	.businesses-website-tags p a{
		color:#4C4C4C;
		padding-left: 2px;
	}
	.businesses-website-tags p span{
	    color:#FF3D00;
	    background: #F9F9F9;
	    border: 1px solid #ECECEC;
	    border-radius: 30px;
	    display: flex;
	    justify-content: center;
	    align-items: center;
	    width: 19px;
	    height: 19px;
	    margin-left:5px;
	}
	.contact-chat-phone-icons{
		padding-top: 10px;
	}
	.contact-icons span a {
	    height: 100%;
	    width: 100%;
	    display: flex;
	    justify-content: center;
	    align-items: center;
	    overflow: hidden;
	    background: #FFFFFF;
	    border: 1px solid #ECECEC;
	    border-radius: 16px;
	    transition: border-color ease-in-out .3s;
	}
	.contact-icons span a:hover,
	.contact-icons span a:active{
		border-color: #82A227;
	}
	.business-listing-content a{
		color: #4C4C4C;
	}
	.pagination-style{
		display: flex;
		justify-content: center;
		margin:35px 0;
	}
	.pagination-style .page-item.active .page-link {
	    border-color: #68819B;
	    background-color: #68819B;
	    color: #fff;
	}
	.pagination-style .page-item .page-link{
		color: #4C4C4C;
	}
	.pagination-style .page-item:first-child .page-link {
	    border-top-left-radius: 8px;
	    border-bottom-left-radius: 8px;
	}
	.pagination-style .page-item:first-child .page-link img{
	    padding-right:8px;
	    vertical-align: middle;
	}
	.pagination-style .page-item:last-child .page-link {
	    border-top-right-radius: 8px;
	    border-bottom-right-radius: 8px;
	}
	.pagination-style .page-item:last-child .page-link img{
	    padding-left:8px;
	    vertical-align: middle;
	}
	.cant-find-the-business {
	    max-width: 600px;
	    margin: auto;
	    display: flex;
	    align-items: center;
	    justify-content: space-between;
	    background-color: #F5F5F5;
		border-radius: 8px;
	    padding: 15px;
	}
	.cant-find-the-business-content {
	    text-align: left;
	}
	.cant-find-the-business-content p{
		text-align: left;
		font-size: 14px;
	}
	.businesses-listing-sec{
		width: 60%;
		margin: 0 0 0 -7px;
	}
	.businesses-listing-map-sec{
		width: 40%;
	    margin-left: 7px;
	    position: relative;
	}
	.business-listing-with-map.row{
		margin: 0 0 0 -7px;
	}
	 .custom-col-md-3{
		flex: 0 0 20%;
	    max-width: 20%;
	 }
	 .custom-col-md-9{
		flex: 0 0 80%;
	    max-width: 80%;	 	
	 }
	 .map-section-content {
	    position: absolute;
	    top: 0;
	    left: 0;
	    right: 0;
	    bottom: 0;
	    width: 100%;
	    height: 100%;
	    background-color: #1b1a1a1f;
	}
	.cancel-btn {
	    background-color: #fff;
	    padding: 7px 16px;
	    box-shadow: 0px 0px 18px rgb(0 0 0 / 15%);
	    border-radius: 4px;
	    display: flex;
	    justify-content: center;
	    align-items: center;
	}
	.search-as-map {
	    max-width: 198px;
	    background: #FFFFFF;
	    box-shadow: 0px 0px 18px rgba(0, 0, 0, 0.15);
	    border-radius: 4px;
	    padding: 9px 12px;
	}
	.search-as-map label.checkbox-label:before{
		background: #DEE2E6;
		border: 1px solid #DEE2E6;
	}
	.map-section-top-bar {
	    display: flex;
	    justify-content: space-between;
	    padding: 0 13px;
	    margin-top: 22px;
	}
	.breadcrumb {
        background-color: #fff;
	    padding: 0.75rem 0;
	    margin-bottom: 5px;
	}
	.breadcrumb-item a {
	    color: #E8523F;
	}
	.breadcrumb-item {
	    font-size: 12px;
	}
	.breadcrumb-item.active {
	    color: #939393;
	}
	.breadcrumb-item + .breadcrumb-item::before {
	    content: ">";
	    color: #939393;
	}
	.businesses-listing-search-filter {
	    display: flex;
	    justify-content: space-between;
	    padding: 35px 7px 25px;
	    align-items: center;
	}
	.most-popular {
	    display: flex;
	    align-items: center;
	}
	.most-popular-form select {
	    border: 0;
	}
	.show-map {
	    margin-left: 35px;
	}
	a.show-map-link {
	    color: #61821E;
	}
	a.show-map-link img{
	    vertical-align: text-bottom;
	}
	.search-category-modal .modal-content .close {
	    position: relative;
	    right: -22px;
	    top: 0;
	}
	.search-category-modal .modal-content .close:hover{
		border:none;
		background-color: transparent;
	}
	.categories-list{
	    margin:10px 0 24px;
	}
	ul.categories-list li {
	    padding: 0px 6px;
	    background: #FFFFFF;
	    border: 1px solid #ECECEC;
	    box-sizing: border-box;
	    border-radius: 16px;
	    position: relative;
	    display: flex;
	    justify-content: space-between;
	    align-items: center;
	    color: #2B273C;
	    font-weight: 400;
	}
	ul.categories-list li:not(:first-child){
		margin-left: 10px;
	}
	.categories-list li .close {
		position: unset !important;
		padding-bottom: 0 !important;
		padding-right: 0 !important;
	}
	.categories-list {
	    display: flex;
	    flex-wrap: wrap;
	}
	.categories-list li .close span {
	    font-size: 30px;
	}
	.search-categories h4{
		font-size: 14px;
		line-height: 18px;
		color: #111111;
	}
	.most-popular-categories {
	    columns: 2;
	    padding: 10px 0;
	    display: block;
	}
	.most-popular-categories .filter-label {
	    font-size: 12px;
	    width: 100%;
	    justify-content: flex-start;
	    border: 1px solid transparent;
	}
	.most-popular-categories label.filter-label.checkbox-pill img {
	    margin-right: 10px;
	}
	.most-popular-categories label.checkbox-pill{
		padding: 10px;
	}
	.most-popular-categories .checkbox-pill-wrapper {
	    display: inline-block;
	    width: 100%;
	}
	.most-popular-categories .checkbox-pill-wrapper input[type="checkbox"]:checked + label{
		width: 100%;
		justify-content: flex-start;
		border: 1px solid #61821E;
	}
	.btn-light-green{
		background-color: #A7C632;
	}
	.apply-filter-btn {
	    width: 100%;
	    position: relative;
	}
	.filter-count {
		position: absolute;
	    left: 15px;
	    background-color: #61821E;
	    font-size: 14px;
	    padding: 4px 5px;
	    border-radius: 10px;
	}
	.filter-button .most-popular-form,
	.business-listing-filerts .results-found{
		display: none;
	}
	@media (max-width: 1199px){
		.without-map-row .col-md-3.pl-0.custom-col-md-3 {
		    flex: 0 0 25%;
		    max-width: 25%;
		}
		.without-map-row .col-md-9.px-0.custom-col-md-9 {
		    flex: 0 0 75%;
		    max-width: 75%;
		}
	}
	@media (max-width: 1099px){
		.without-map-row .businesses-listing-sec.with-map-column {
		    width: 95%;
		}
		.without-map-row .with-map-column .business-listing-wrapper {
		    width: 50%;
		}
	}
	@media (max-width: 991px){
		.without-map-row .col-md-3.pl-0.custom-col-md-3 {
		    flex: 0 0 30%;
		    max-width: 30%;
		}
		.without-map-row .col-md-9.px-0.custom-col-md-9 {
		    flex: 0 0 70%;
		    max-width: 70%;
		}
		.without-map-row .show-map{
			display: none;
		}		
	}
	@media (max-width: 767px){
		.without-map-row .col-md-3.pl-0.custom-col-md-3,
		.without-map-row .col-md-9.px-0.custom-col-md-9{
		    flex: 0 0 100%;
		    max-width: 100%;
		}
		.without-map-row .businesses-listing-sec.with-map-column,
		.without-map-row .business-listing-with-map.row{
		    margin: auto;
		}
		.show-map .businesses-listing-search-filter,
		.businesses-listing-search-filter{
			display: none;
		}

		.filter-button{
		    display: flex;
		    justify-content: space-between;
		    align-items: center;
		}
		.filter-button h5{
			padding-bottom: 0;
		}
		.business-listing-filerts .result-found,
		.filter-button .most-popular-form{
			display: block;
		}
	}
	@media (max-width: 575px){
		 .full-width-575{
		 	width: 100% !important;
		 }
		 .pagination-style,
		 .cant-find-the-business{
		 	display: none;
		 }
	}	
</style>

<script>
	jQuery(document).ready(function(){
		// var accordionID = $('.cusotm-accordion-control').attr('aria-controls');
		// jQuery(".cusotm-accordion-control[aria-controls='" + accordionID + "']").click(function(){
		// 	jQuery("#" + accordionID).slideToggle();
		// });

		// Listing Slider
		jQuery('.business-listing-slider').slick({
		  infinite: false,
		  dots: true,
		  arrow: true,
		  slidesToShow: 1,
		  slidesToScroll: 1
		});
	});
</script>

<?php get_footer(); ?>
