<?php
// Template Name: Services
?>

<?php get_header(); ?>
<?php wp_enqueue_style( 'ibd-business-listing-shortcode' ); ?>

<?php
    global $post;
    $is_get_parameter_available = true;
    $keyword = '';
    if(isset($_GET['keyword']) && !empty($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
    }
    if(isset($_GET['business_verified']) && !empty($_GET['business_verified'])) {
        $business_verified = $_GET['business_verified'];
        $is_get_parameter_available = true;
    }
    if(isset($_GET['order_by']) && !empty($_GET['order_by'])) {
        $order_by = $_GET['order_by'];
        $is_get_parameter_available = true;
    }
    $city_name = 'All';
    if(isset($_GET['city']) && !empty($_GET['city'])) {
        $city = $_GET['city'];
        $city_name = get_the_title($city);
        $is_get_parameter_available = true;
    }
    $category_name = 'All';
    if(isset($_GET['category']) && !empty($_GET['category'])) {
        $category = $_GET['category'];
        $category_name = get_term_by('slug', $category, 'wyz_business_category')->name;
        $is_get_parameter_available = true;
    }
    if(isset($_GET['tag']) && !empty($_GET['tag'])) {
        $tag = $_GET['tag'];
    }
    if(isset($_GET['available_direct_messaging']) && !empty($_GET['available_direct_messaging'])) {
        $available_direct_messaging = $_GET['available_direct_messaging'];
        $is_get_parameter_available = true;
    }
    if(isset($_GET['email']) && !empty($_GET['email'])) {
        $email = $_GET['email'];
        $is_get_parameter_available = true;
    }
    if(isset($_GET['phone_number']) && !empty($_GET['phone_number'])) {
        $phone_number = $_GET['phone_number'];
        $is_get_parameter_available = true;
    }
    if(isset($_GET['opening_hours']) && !empty($_GET['opening_hours'])) {
        $opening_hours = $_GET['opening_hours'];
        $is_get_parameter_available = true;
    }
    if(isset($_GET['address']) && !empty($_GET['address'])) {
        $address = $_GET['address'];
        $is_get_parameter_available = true;
    }
    if(isset($_GET['special_offers']) && !empty($_GET['special_offers'])) {
        $special_offers = $_GET['special_offers'];
        $is_get_parameter_available = true;
    }
    if(isset($_GET['paged']) && !empty($_GET['paged'])) {
        $page = $_GET['paged'];
    }
wp_enqueue_style( 'ibd_services_filter_css', get_stylesheet_directory_uri() . '/css/service-filter-shortcode.css', array(), '5.5.4');

?>
<section class="top-section-info" style="opacity: 0">
    <div class="container pd-px-0">
        <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-6 mobile-container">
                <h3 class="mb-mx-7"><span>City:</span> <span class="city-name"><?php echo $city_name; ?></span></h3>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 text-center mobile-container">
                <h3 class="mb-mx-7"><span>Category:</span> <span class="category-name"><?php echo $category_name; ?></span></h3>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12 text-right mobile-container">
                <h3><span>Results:</span> <span class="services-pages"></span></h3>
            </div>
        </div>
    </div>
</section>
<section class="business-section" style="opacity: 0">
    <div class="container pd-px-0">
        <form method="POST" action="" class="search-product-form business-filters services-filter-form">

            <div class="advcance-searched-option">
                 <span><i class="fa fa-check-circle blue-color" aria-hidden="true"></i>With this symbol, we have marked businesses who claimed their business listing and which are 100% verified</span>
                <div class="row">
                    <div class="col-md-12 pd-0 filters-your-result-mobile mb-15 d-flex">
                        <label class="flex-0-3 font-style flex-mx-0-4 filters-your-result-accordian"  data-toggle="collapse" data-target="#filters-your-result">Filter your Results: <i class="fa fa-angle-down" aria-hidden="true"></i></label>

                        <div class="form-group filter-verified-business flex-1">
                            <ul class="ibd_job_types">
                                <li>
                                    <label>
                                        <input class="services-filters" type="checkbox" id="show-only" name="business_verified" value="1" <?php echo $business_verified == 1 ? 'checked' : '' ?>> Verified Businesses
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row all-filters-your-result" id="">
                    <div class="col-md-12 col-sm-12 col-xs-12 all-service-filter-item" >
                        <div class="custom-form-style product-form-style pd-0">
                            <div class="form-group service-category-info filter-business-by mt-mx-10" >
                                <input type="text" class="services-filters" name="keyword" placeholder="Keyword" value="<?php echo $keyword; ?>">
                                <div class="location-wrapper fields-wrapper">
                                    <input type="text" class="search-fields" data-search-for="city" placeholder="City or County" value="<?php echo ($city_name) == 'All' ? '' : $city_name; ?>">
                                    <i class="fa fa-map-marker"></i>
                                    <a href="javascript:void(0)" class="close-btn-item" style="display: none;"><img src="<?php echo get_stylesheet_directory_uri() . '/images/close-icon.svg'; ?>" alt="Close icon on Irish Business Directory"></a>
                                    <input class="hidden-input" type="hidden" name="city" value="<?php echo $city ?>">
                                    <ul></ul>
                                </div>
                                <div class="category-wrapper fields-wrapper">
                                    <input type="text" class="search-fields " data-search-for="category" placeholder="Category" value="<?php echo ($category_name == 'All') ? '' : $category_name; ?>">
                                    <i class="fa fa-tag"></i>
                                    <a href="javascript:void(0)" class="close-btn-item" style="display: none;"><img src="<?php echo get_stylesheet_directory_uri() . '/images/close-icon.svg'; ?>" alt="Close icon on Irish Business Directory"></a>
                                    <input class="hidden-input" type="hidden" name="category" value="<?php echo $category; ?>">
                                    <ul></ul>
                                </div>
                                <select class="services-filters" id="" name="order_by">
                                    <option value="" selected>Order Business by...</option>
                                    <option value="most_popular" <?php echo $order_by == 'most_popular' ? 'selected' : ''; ?>>The Most Popular</option>
                                    <option value="latest" <?php echo $order_by == 'latest' ? 'selected' : ''; ?>>Last Added</option>
                                    <option value="oldest" <?php echo $order_by == 'oldest' ? 'selected' : ''; ?>>First Added</option>
                                    <option value="a_z" <?php echo $order_by == 'a_z' ? 'selected' : ''; ?>>A-Z</option>
                                    <option value="z_a" <?php echo $order_by == 'z_a' ? 'selected' : ''; ?>>Z-A</option>
                                    <option value="random" <?php echo $order_by == 'random' ? 'selected' : ''; ?>>Random</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 p-mx-0 pd-0 advanced-search-accordian">
                        <div class="custom-form-style product-form-style pd-0">
                            <div class="form-group service-category-info filter-business-by">
                                <button type="button" class="btn btn-info advanced-search mb-mx-0" data-toggle="collapse" data-target="#advanced-search">Advanced Search <i class="fa fa-angle-down" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row collapse advanced-search-mobile m-mx-0" id="advanced-search">
                        <div class="col-md-12 col-sm-12 col-xs-12 pd-0">
                            <div class="custom-form-style product-form-style pl-0 pr-0 p-mx-0 mb-mx-15 mt-mx-10">
                                <label for="show-only" class="flex-4 font-style-2">Business WHO Have:</label>
                                <div class="form-group filter-verified-business flex-7-5 pd-0">
                                    <ul class="ibd_job_types">
                                        <li>
                                            <label>
                                                <input class="services-filters" type="checkbox" id="show-only" name="email" value="1" <?php echo $email == 1 ? 'checked' : '' ?>> email
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input class="services-filters" type="checkbox" id="show-only" name="phone_number" value="1" <?php echo $phone_number == 1 ? 'checked' : '' ?>> phone Number
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input class="services-filters" type="checkbox" id="show-only" name="opening_hours" value="1" <?php echo $opening_hours == 1 ? 'checked' : '' ?>> opening Hours
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input class="services-filters" type="checkbox" id="show-only" name="address" value="1" <?php echo $address == 1 ? 'checked' : '' ?>> address
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="submit" style="display: none;">
            <input type="hidden" id="page" name="paged" value="<?php echo $page ?>">
        </form>
    </div>
</section>
<section class="position-relative">
    <div class="loading-services loading-services-style-info" style="display: none;">
        <i class="fa fa-circle-o-notch fa-spin"></i>
    </div>
</section>
<section class="business-section-info pd-60">
    <div class="container position-relative pd-px-0">

        <div class="business-list">

        </div>
    </div>
</section>

<!-- modal -->

  <!-- Modal -->
      <!-- Button trigger modal -->

        <!-- Modal -->
        <div class="modal fade sign-up-sign-in-modal" id="sign-up-sign-in-modal" tabindex="-1" role="dialog" aria-labelledby="sign-up-sign-in-modalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              <div class="modal-body">
                <div class="modal-body-info">
                    <h3 class="modal-main-title">To add this business to your FAVOURITES you would need to</h3>
                    <div class="all-user-sign-up-sign-in">
                        <a href="<?php echo site_url(); ?>/signup/" class="wyz-button wyz-primary-color icon" title="My Account">Signup<i class="fa fa-angle-right"></i></a>
                        <div class="own-choice"><span>Or</span></div>
                        <a href="<?php echo site_url(); ?>/signup/?action=login" class="wyz-button" title="Signin">Signin</a>
                    </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <style>
            .all-user-sign-up-sign-in {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 82%;
                margin: auto;
            }
            .own-choice {
                width: 30%;
                height: 2px;
                background-color: #b1b1b1;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .own-choice>span {
                background-color: #bdbdbd;
                height: 30px;
                width: 30px;
                border-radius: 50%;
                padding: 6px;
                line-height: 133%;
                text-transform: uppercase;
                color: #fff !important;
            }
            #sign-up-sign-in-modal button.close {
                position: absolute;
                z-index: 9;
                right: 0;
                top: -3px;
                background-color: transparent;
                border: 0;
                font-size: 28px;
                line-height: 100%;
            }
            h3.modal-main-title {
                text-align: center;
            }
            .modal-body-info {
                padding: 30px 0;
            }
            div#sign-up-sign-in-modal {
             	z-index: 1000000 !important;
         	    background-color: rgba(0,0,0,.5);
            }

            .modal-backdrop{
            	opacity: .5 !important;
            	z-index: 100000 !important;
            	background-color: transparent !important;
            }
            .category-overflow {
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            @media(max-width: 575px){
                .all-user-sign-up-sign-in a {
                    float: none;
                    width: 100%;
                }

                .all-user-sign-up-sign-in {
                    flex-direction: column;
                    width: 100%;
                }
                .own-choice {
                    width: 100%;
                    margin: 30px 0;
                }
               .sign-up-sign-in-modal .modal-dialog{
                    padding: 30px;
                }

            }
        </style>
<!-- end -->
<?php get_footer(); ?>

<script type="text/javascript">
    services_categories = <?php echo json_encode($categories['children']) ?>;
    selected_category = '<?php echo $get_category;?>';
    <?php
        if($is_get_parameter_available == true) {
            ?>
                trigger_serive_update = 1;
            <?php
        }
    ?>
</script>

<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() . '/js/services.js?ver=1.0.1'; ?>"></script>

<script>
    jQuery(function(){
        jQuery('.advanced-search ').on('click',function(){
            jQuery(this).closest('.service-category-info').addClass('down-icon');
            var collapse = jQuery(this).closest('.advcance-searched-option').find('.advanced-search-mobile.collapse').hasClass('in');
            if(collapse == true){
               jQuery(this).closest('.service-category-info').removeClass('down-icon');
            }
        });
        jQuery('.filters-your-result-accordian').on('click',function(){
            jQuery(this).closest('.filters-your-result-mobile').addClass('filter-down-icon');
            jQuery(this).closest('.advcance-searched-option').removeClass('filter-style');
            var collapse = jQuery(this).closest('.advcance-searched-option').find('.all-filters-your-result.collapse').hasClass('in');
            if(collapse == true){
               jQuery(this).closest('.filters-your-result-mobile').removeClass('filter-down-icon');
               jQuery(this).closest('.advcance-searched-option').addClass('filter-style');
            }

        });
        var get_width = $(window).width();
        if (get_width < 575) {
        	jQuery('.filters-your-result-accordian').closest('.advcance-searched-option').find('.all-filters-your-result').addClass('collapse');
            jQuery('.filters-your-result-accordian').closest('.advcance-searched-option').find('.all-filters-your-result').attr('id','filters-your-result');
            jQuery('.filters-your-result-accordian').closest('.advcance-searched-option').addClass('filter-style');
        }
        jQuery('.page-template-services.page-id-122846').find('.page-title-social').addClass('page-main-title');

    });
</script>
