<?php
/**
 * Irish Rest API
 */
use Api\Authentication\Authentication;

class IrishWebAPI extends Authentication {

	protected static $instance = false;

	private $is_user_logged_in = false;

	public function __construct(){

		$this->namespace = 'v1/';
		add_filter('rest_api_init', array($this, 'register_routes'));

		parent::__construct( true );

	}

	public static function init(){
		if( !self::$instance ){
			return self::$instance = new self();
		}
		return self::$instance;
	}
	// Register our routes.
    public function register_routes() {

    	register_rest_route( $this->namespace, '/login/', array(
            // Here we register the readable endpoint for collections.
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'single_sign_on' ),
            ),
        ) );

        register_rest_route( $this->namespace, '/business/', array(
            // Here we register the readable endpoint for collections.
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'get_businesses' ),
            )
        ) );

        register_rest_route( $this->namespace, '/business/profile/(?P<slug>[-_\w]+)', array(
            // Here we register the readable endpoint for collections.
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'get_business_details' ),
            ),
        ) );

        register_rest_route( $this->namespace, '/business/jobs/(?P<business_id>\d+)', array(
            // Here we register the readable endpoint for collections.
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'get_business_jobs' ),
            ),
        ) );

        register_rest_route( $this->namespace, '/subscription/(?P<user_id>\d+)', array(
            // Here we register the readable endpoint for collections.
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'get_subscription' ),
            ),
        ) );

        register_rest_route( $this->namespace, '/business/meta/(?P<business_id>\d+)(?:/(?P<metakey>[-\w]+))?', array(
            // Here we register the readable endpoint for collections.
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'get_business_meta' ),
            ),
        ) );

        register_rest_route( $this->namespace, '/business/leads/(?P<user_id>\d+)', array(
            // Here we register the readable endpoint for collections.
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'get_business_leads' ),
            ),
        ) );

        register_rest_route( $this->namespace, '/user-profile/(?P<user>[-\w]+)', array(
            // Here we register the readable endpoint for collections.
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'get_user_profile' ),
            ),
        ) );

		register_rest_route( $this->namespace, '/trending_businesses',array(
			array(
				'method'	=> 'GET',
				'callback'	=> array( $this, 'trending_businesses' ),
			)
		) );

		register_rest_route( $this->namespace, '/business_categories',array(
			array(
				'method'	=> 'GET',
				'callback'	=> array( $this, 'business_categories' ),
			)
		) );

		register_rest_route( $this->namespace, '/locations',array(
			array(
				'method'	=> 'GET',
				'callback'	=> array( $this, 'business_locations' ),
			)
		) );

		register_rest_route( $this->namespace, '/offers',array(
			array(
				'method'	=> 'GET',
				'callback'	=> array( $this, 'business_offers' ),
			)
		) );

		register_rest_route( $this->namespace, '/verified-business',array(
			array(
				'method'	=> 'GET',
				'callback'	=> array( $this, 'verified_business' ),
			)
		) );

    }

    public function get_user_profile( $req ){

    	$user = $req->get_param('user');
    	if( is_numeric( $user ) ) {
            $user_data = get_user_by('id', $user);
        }
        else {
            $user_data = get_user_by('login', $user);
        }
        if(empty( $user_data )){
            return $this->error('not_found');
        }

        $formatted_user_data =  array();
        $user_information = get_user_meta( $user_data->ID );

        $formatted_user_data[] = array(

        	'Id' 				=> $user_data->ID,
        	'nickname'			=> $user_information['nickname'],
        	'first_name'    	=> $user_information['first_name'],
            'last_name'     	=> $user_information['last_name'],
            'email'     		=> $user_information['billing_email'],
            'phone'     		=> $user_information['billing_phone'],
            'availble_points'	=> $user_information['points_available'],
            'address'			=> $user_information['billing_address_1'],
            'city'				=> $user_information['billing_city'],
            'state'				=> $user_information['billing_state'],
            'country'			=> $user_information['billing_country'],
            'postal_code'		=> $user_information['billing_postcode'],
            'Pmpro_Expiration'	=> $user_information['pmpro_ExpirationYear']


        );

    	return $formatted_user_data;
    }


    public function verified_business(){

        $verified_business =  get_posts(
			array(
	            'post_type' => 'wyz_business',
	            'post_status' => 'publish',
	    		'orderby' => 'date',
	    		'order'   => 'DESC',
	            'posts_per_page'    => 5,
	            'meta_query' => [
	                [
	                    'key'    => 'wyz_business_verified',
	                    'value'  => 'yes',
	                    'compare' => '='
	                ]
	            ]
        	)
		);
		return array_map( function( $b ){
			$b->meta = array(
				'logo' =>  get_post_meta( $b->ID, 'wyz_business_logo', true ) ,
				'description' => strip_tags(get_post_meta( $b->ID, 'wyz_business_description', true )),
			);
			return $b;
		}, $verified_business );
    }


	public function business_categories(){
		return get_terms(
			array(
				'taxonomy'	=> 'wyz_business_category',
				'number'	=> 7,
				'count'		=> true,
				'orderby' => 'count',
				'order' => 'DESC'
			)
		);
	}

	public function trending_businesses(){
		$business = get_posts(
			array(
				'post_type'	=> 'wyz_business',
				'posts_per_page' => 10,
				'post_status'	=> 'publish',
				'meta_query'	=> array(
					'visit_counts' => array(
						'key'	=> 'wyz_business_visits_count',
						'compare'	=> 'EXISTS'
					),
					'orderby' => array(
						'visit_counts' => 'DESC'
					)
				)
			)
		);
		return array_map( function( $b ){
			$b->meta = array(
				'post_thumbnail' => current( get_post_meta( $b->ID, 'business_gallery_image', true ) ),
				'location' 	=> get_the_title( get_post_meta( $b->ID, 'wyz_business_country', true ) ),
				'website' 	=> get_post_meta( $b->ID, 'wyz_business_website', true ),
				'email' 	=> get_post_meta( $b->ID, 'wyz_business_email1', true ),
				'phone'		=> get_post_meta( $b->ID, 'wyz_business_phone1', true ),
			);
			return $b;
		}, $business );
	}

	public function business_locations(){
		// global $wpdb;
		// $sql = "SELECT COUNT( T2.ID ) as count FROM $wpdb->posts T1, $wpdb->posts T2
		// WHERE ";
		$locations = get_posts(
			array(
				'post_type'	=> 'wyz_location',
				'posts_per_page' => -1,
				'post_status'	=> 'publish',
			)
		);
		$mapped = array_map( function( $l ){
			$count = new WP_Query(
				array(
					'post_type'	=> 'wyz_business',
					'post_status'	=> 'publish',
					'meta_query'	=> array(
						'visit_counts' => array(
							'key'	=> 'wyz_business_country',
							'value'	=> $l->ID,
						)
					)
				)
			);
			$l->thumbnail = get_the_post_thumbnail_url( $l->ID, 'thumbnail' );
			$l->count = $count->found_posts;
			return $l;
		}, $locations );

		usort( $mapped, function( $a, $b ){ return $a->count < $b->count ; } );

		return array_slice( $mapped, 0, 10 );
	}

	public function business_offers(){
		$offers = get_posts(
			array(
	            'post_type' => 'wyz_offers',
	            'post_status' => 'publish',
	            'posts_per_page'    => 5,
	        )
		);
		return array_map( function( $of ){
			$image_id = get_post_meta($of->ID, 'wyz_offers_image_id', true);
			$offer_logo_temp = wp_get_attachment_image_src( $image_id, 'thumbnail');
			if ( $offer_logo_temp  ) {
				$offer_logo = $offer_logo_temp[0];
			}
			else {
				$offer_logo = get_stylesheet_directory_uri().'/images/offer-image-placeholder.jpg';
			}
			$of->meta = array(
				'thumbnail' => $offer_logo,
				'discount'  => get_post_meta( $of->ID, 'wyz_offers_discount', true ),
			);
			return $of;
		}, $offers );
	}


    public function get_business_leads( $req ){

    	global $wpdb;

    	$businesslead = array();
    	$page_arr = array();

    	$user_id = $req->get_param('user_id');

    	$page = 1;
	    $page = isset($_GET['paged']) && !empty( $_GET['paged'] ) && is_numeric( $_GET['paged'] ) ? $_GET['paged'] : $page;

	    $limit = 20;
	    $offset = ($page - 1) * $limit;

	    $args = array(
	        'post_type' => 'wyz_business',
	        'status'    => 'publish',
	        'posts_per_page' => -1,
	        'fields'  => 'ids',
	        'author'  => $user_id
	    );
	    $businesses = get_posts( $args );
	    $business_imp = implode( ',', $businesses );

	    // database table name
	    $tName = $wpdb->prefix . 'business_leads';

	    //if asked for trashed leads
	    $status = (isset($_GET['status']) && $_GET['status'] == 'trash') ? 0 : 1 ;

	    //for business leads pagination
	    $paginationsql = "SELECT COUNT(*) as count FROM $tName WHERE FIND_IN_SET(`business_id`, '$business_imp') AND `status` = '$status' ORDER BY `created_at` DESC ";
	    $count = $wpdb->get_var( $paginationsql );
	    $page_count = ceil( $count / $limit );
	    $lead_from = ( ( $page - 1 )  * $limit ) + 1 ;
        $lead_to = $count < $limit ? $count : ($limit * $page) > $count ? $count : ($limit * $page) ;

	    if($lead_from == $lead_to){
	      $lead_from_to = $lead_from;
	    }else{
	      $lead_from_to = $lead_from . ' - ' . $lead_to;
	    }

	    $lead_from_to  = $lead_from_to . ' of ' . $count;

	    //for business leads data
	    $sql = "SELECT * FROM $tName WHERE FIND_IN_SET(`business_id`, '$business_imp') AND `status` = '$status' ORDER BY `created_at` DESC LIMIT $offset, $limit";
	    $res = $wpdb->get_results( $sql );


	    if( !empty($res) ){

	    	$businesslead['business_leads'] = $res;
	    	$page_arr = array(
				    	'total_pages' => $page_count,
				    	'total_found_leads' => $count,
				    	'leads_from' => $lead_from,
				    	'leads_to' => $lead_to,
				    	'current_page' => $page,
				    	'formatted_from_to'  => $lead_from_to
						);
	    }
	    else{

	    	$businesslead['businesslead'] = 'No Leads Found';
	    }

		$response  = array_merge($businesslead, $page_arr);

    	return $response;
    }


    public function get_subscription( $req ){

    	$user_id = $req->get_param('user_id');
    	$subscription_details = pmpro_getMembershipLevelForUser($user_id);
    	return $subscription_details;

    }

    public function get_business_jobs( $req ){

    	$business_id = $req->get_param('business_id');

    	$args = array(
				'post_type' => 'job_listing',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'meta_query' => array(
					array(
						'key' => '_wyz_job_listing',
						'value' => $business_id
					)
				)
		);
    	$job_query  = new WP_Query( $args);
    	$jobs = array();
    	if( $job_query->post_count <= 0 ){
    		return $jobs;
    	}
    	foreach ($job_query->posts as $jobsdata) {

    		$jobs[] = $jobsdata;
    	}
    	return $jobs;
    }


    public function single_sign_on(){

		$nonce = wp_create_nonce( "wp_rest" );
        $user = wp_signon(array('user_login' => $_GET['username'],
            'user_password' => $_GET['password'], "rememberme" => true), false);
        if ( is_wp_error( $user ) ) {
            return $user;
        }

	    wp_set_current_user ( $user->ID );
	    wp_set_auth_cookie  ( $user->ID );
	    $this->is_user_logged_in = true;
        return array('user' => $user, 'nonce' => $nonce );
	}

    public function get_businesses(){

    	$business = array();

    	$page = isset($_GET['paged']) && !empty($_GET['paged']) ? $_GET['paged'] : 1;

	    $per_page = 20;

	    $services_args = array(
	        'post_type' => 'wyz_business',
	        'post_status' => 'publish',
	        'paged' => $page,
	    );

	    // meta query
	    $meta_query = array(
	        'relation' => 'AND',
	    );

	    $tax_query = array();

	    if(isset($_GET['keyword']) && !empty($_GET['keyword'])) {
	        $services_args['s'] = $_GET['keyword'];
	    }

	    // order by
	    if (isset($_GET['order_by'])) {
	        if ($_GET['order_by'] == 'most_popular') {
	            $services_args['orderby'] = 'meta_value';
	            $services_args['meta_key'] = 'wyz_business_visits_count';
	            $services_args['order'] = 'DESC';
	        }
	        if ($_GET['order_by'] == 'latest') {
	            $services_args['orderby'] = 'date';
	            $services_args['order'] = 'DESC';
	        }
	        if ($_GET['order_by'] == 'oldest') {
	            $services_args['orderby'] = 'date';
	            $services_args['order'] = 'ASC';
	        }
	        if ($_GET['order_by'] == 'a_z') {
	            $services_args['orderby'] = 'title';
	            $services_args['order'] = 'ASC';
	        }
	        if ($_GET['order_by'] == 'z_a') {
	            $services_args['orderby'] = 'title';
	            $services_args['order'] = 'DESC';
	        }
	        if ($_GET['order_by'] == 'random') {
	            $services_args['orderby'] = 'rand';
	        }
	    }
	    if(isset($_GET['business_verified']) && !empty($_GET['business_verified'])) {
	        $meta_query[] = array(
	            'key' => 'wyz_business_verified',
	            'compare' => '=',
	            'value' => 'yes',
	        );
	    }


	    if(isset($_GET['city']) && !empty($_GET['city'])) {
	        $meta_query[] = array(
	            'key' => 'wyz_business_country',
	            'compare' => '=',
	            'value' => $_GET['city'],
	        );
	    }

	    if(isset($_GET['category']) && !empty($_GET['category'])) {
	        $tax_query[] = array(
	            'taxonomy' => 'wyz_business_category',
	            'field'    => 'slug',
	            'terms'    => $_GET['category'],
	        );
	    }

	    if(isset($_GET['tag']) && !empty($_GET['tag'])) {
	        $tax_query[] = array(
	            'taxonomy' => 'wyz_business_tag',
	            'field'    => 'slug',
	            'terms'    => $_GET['tag'],
	        );
	    }


	    if(isset($_GET['email']) && !empty($_GET['email'])) {
	        $meta_query[] = array(
	            'key' => 'wyz_business_email1',
	            'compare' => '!=',
	            'value' => ''
	        );
	    }

	    if(isset($_GET['phone_number']) && !empty($_GET['phone_number'])) {
	        $meta_query[] = array(
	            'key' => 'wyz_business_phone1',
	            'compare' => '!=',
	            'value' => ''
	        );
	    }

	    if(isset($_GET['opening_hours']) && !empty($_GET['opening_hours'])) {
	        $meta_query[] = array(
	            'key' => 'wyz_open_close_monday_status',
	            'compare' => 'EXISTS'
	        );
	    }

	    if(isset($_GET['address']) && !empty($_GET['address'])) {
	        $meta_query[] = array(
	            'key' => 'wyz_business_street',
	            'compare' => '!=',
	            'value' => ''
	        );
	    }

	    if(count($meta_query) > 1) {
	        $services_args['meta_query'] = $meta_query;
	    }

	    if(!empty($tax_query)) {
	        $services_args['tax_query'] = $tax_query;
	    }
	    // Premium
	    $premium_args = $services_args;
	    $premium_args['post__in'] = idb_group_business_listings();
	    if( !array_key_exists( 'orderby', $premium_args) ){
	        $premium_args['orderby'] = 'post__in';
	    }
	    $p_max_pages = ceil(count( idb_group_business_listings() ) / $per_page);

	    $premium_args['paged'] = $p_max_pages < $page ? $p_max_pages : $page;
	    $premium_args['posts_per_page'] = $per_page;

	    $premiums = new WP_Query;
	    $premium_businesses = $premiums->query( $premium_args );

	    $business['premiums'] = $page <= $p_max_pages ? $premium_businesses  : [] ;

	    $normal_args = $services_args;


	    $normal_args['posts_per_page'] = $p_max_pages < $page ? $per_page : $per_page - $premiums->post_count ;
	    $normal_args['post__not_in'] = idb_group_business_listings();

	    $normal_args['paged'] = $page > $p_max_pages ? $page - $p_max_pages : 1 ;

	    $offset_start = ( $p_max_pages >= $page ) ? 0 : ( $p_max_pages * $per_page ) - count( idb_group_business_listings() ) + 1;
	    $offset = ( $normal_args['paged'] - 1 ) * $per_page + $offset_start;
	    $normal_args['offset'] = $offset ;


	    $normal = new WP_Query;

	    $business['defaults'] = $normal->query( $normal_args );




	    $from = ($per_page * $page) - ($per_page - 1);
	    $total_found_posts = $normal->found_posts + $premiums->found_posts;
	    if(($per_page * $page) <= ($total_found_posts)){
	        $to = ($per_page * $page);
	    }else{
	        $to = $total_found_posts;
	    }

	    $max_pages = ceil( $total_found_posts / $per_page );

	    if($from == $to){
	      $from_to = $from;
	    }else{
	      $from_to = $from . ' - ' . $to;
	    }

	    $from_to  = $from_to . ' of ' . $total_found_posts;

	    if(empty($total_found_posts)) {
	        $from_to = 0;
	    }

	    $page_arr = array(
	    	'total_pages' => $max_pages,
	    	'total_found_posts' => $total_found_posts,
	    	'post_from' => $from,
	    	'post_to' => $to,
	    	'current_page' => $page,
	    	'formatted_from_to'  => $from_to
		);
		foreach ($business['premiums'] as $key => $value) {
			// code...
			//echo get_post_meta( $value->ID, 'wyz_business_city', true);
			$business['premiums'][$key]->city = get_post_meta( $value->ID, 'wyz_business_city', true);
			$business['premiums'][$key]->contact = get_post_meta( $value->ID, 'wyz_business_phone1', true);
			$business['premiums'][$key]->rating	 = $this->getBusRating($value->ID);
			$business['premiums'][$key]->location = get_post_meta( $value->ID, 'wyz_business_location', true);
		}
		foreach ($business['defaults'] as $key => $value) {
			// code...
			//echo get_post_meta( $value->ID, 'wyz_business_city', true);
			$business['defaults'][$key]->city = get_post_meta( $value->ID, 'wyz_business_city', true);
			$business['defaults'][$key]->contact = get_post_meta( $value->ID, 'wyz_business_phone1', true);
			$business['defaults'][$key]->rating	 = $this->getBusRating($value->ID);
			$business['defaults'][$key]->location = get_post_meta( $value->ID, 'wyz_business_location', true);
		}





	 		//print_r($business['premiums']);

	    $business = array_merge( $business, $page_arr );



	    return rest_ensure_response( $business );


    }


	public function getBusRating($businessid) {

		$rating_num = get_post_meta( $businessid, 'wyz_business_rates_count', true );
		$rating_sum = get_post_meta( $businessid, 'wyz_business_rates_sum', true );
		$rating;
		if ( ! empty( $rating_num ) && ! empty( $rating_sum ) && $rating_num > 0 ) {

			$rating = number_format( ( (float) $rating_sum ) / $rating_num, 1 ) + 0;
		}
		else {
			$rating = 0;
		}
		return $rating;
	}

    public function get_business_details( $req ){

		$args = array(
		  'name'        => $req->get_param('slug'),
		  'post_type'   => 'wyz_business',
		  'post_status' => 'publish',
		  'numberposts' => 1
		);

		$business_profile_data = array();
		$business_profiles = get_posts( $args );

		foreach ($business_profiles as $business_profile) {
			$businessid = $business_profile->ID;
		}
		//Business Owner Id
		$author_id = get_post_field('post_author', $businessid);

		//Workind day and hours
		$days = array(
			    'monday',
			    'tuesday',
			    'wednesday',
			    'thursday',
			    'friday',
			    'saturday',
			    'sunday',
				);
		$opening_hours = array();
		$day_prefix = 'wyz_open_close_';
		foreach( $days as $day ){
		    $status = get_post_meta( $businessid, $day_prefix.$day.'_status', true );

		    if( $status == 'custom' ){
		        $opening_hours[ $day ] = get_post_meta( $businessid, $day_prefix.$day, true );
		    }
		    else{
		        $opening_hours[ $day ] = $status;
		    }
		}

		// Business Category
		$businesscategories = get_the_terms( $businessid, 'wyz_business_category', true );
		$business_category = array();
		$i=0;
		foreach( $businesscategories as $businesscategory){

			$business_category[$i]['name'] = $businesscategory->name;
			$business_category[$i]['slug'] = $businesscategory->slug;
			$business_category[$i]['is_parent'] = false;
			if( $businesscategory->parent == 0) {

				$business_category[$i]['is_parent'] = true;

			}
		$i++;
		}


		//Business Rating
		$rating_num = get_post_meta( $businessid, 'wyz_business_rates_count', true );
		$rating_sum = get_post_meta( $businessid, 'wyz_business_rates_sum', true );
		$rating;
		if ( ! empty( $rating_num ) && ! empty( $rating_sum ) && $rating_num > 0 ) {

			$rating = number_format( ( (float) $rating_sum ) / $rating_num, 1 ) + 0;
		}
		else {
			$rating = 0;
		}

		//Business Posts
		$business_posts = get_post_meta( $businessid, 'wyz_business_posts', true );

		if ( ! empty( $business_posts ) ) {
			$args = array(
				'post_type' => 'wyz_business_post',
				'post__in' => 	$business_posts,
				'post_status' => 'publish',
				'posts_per_page' => -1,
			);
		}
		$business_post_query = new WP_Query( $args );


		//Business Offers
		$offer_data = array();
		$offer_query = new WP_Query( array(
							'post_type' => 'wyz_offers',
							'posts_per_page' => -1,
							'post_status' => 'publish',
							'meta_key' => 'business_id',
							'meta_value' => $businessid
						) );
		if( $offer_query->posts){
			$j = 0;
			foreach ($offer_query->posts as $offers) {
				$offer = get_post_meta($offers->ID);
				$offer_data[$j]['offer_description'] = $offer['wyz_offers_description'];
				$offer_data[$j]['offer_image'] 	     = $offer['wyz_offers_image'];
				$offer_data[$j]['offer_discount']    = $offer['wyz_offers_discount'];
				$offer_data[$j]['offer_expire']      = $offer['wyz_offer_expire'];
				// $offer_data[]['']
				$j++;
				}
		}

		//Business Tags
		// $business_tags = get_the_term_list( $businessid, 'wyz_business_tag');
		// print_r(strip_tags( $business_tags));
		// exit();

		//Business Profile data
		$business_profile_data['business_id'] 		  = $businessid;
		$business_profile_data['business_name']		  = get_the_title( $businessid );
		$business_profile_data['logo']		  		  = get_post_meta( $businessid, 'wyz_business_logo', true);
		$business_profile_data['logobg']              = get_post_meta( $businessid, 'wyz_business_logobg', true);
		$business_profile_data['business_gallery']	  = get_post_meta( $businessid, 'business_gallery_image',true);
		$business_profile_data['business_description']= get_post_meta( $businessid, 'wyz_business_description', true);
		$business_profile_data['slogan']              = get_post_meta( $businessid, 'wyz_business_slogan', true);

		$business_profile_data['business_category']	  = $business_category;
		$business_profile_data['views']         	  = WyzHelpers::get_business_visits_count($businessid);
		$business_profile_data['favcount']			  = WyzHelpers::get_business_favorite_count($businessid);
		$business_profile_data['opening_hours'] 	  = $opening_hours;
		$business_profile_data['map']                 = get_post_meta($businessid,'wyz_business_location',true);
		$business_profile_data['business_offer']	  = $offer_data;
		$business_profile_data['business_post']		  = $business_post_query->posts;
		$business_profile_data['contact_information'] = array(
														'Phone_number_1' => esc_html( get_post_meta( $businessid, 'wyz_business_phone1', true ) ),
														'Phone_number_2' => esc_html( get_post_meta( $businessid, 'wyz_business_phone2', true ) ),
														'Email_id_1'   => get_post_meta( $businessid, 'wyz_business_email1', true ),
														'Email_id_2'   => get_post_meta( $businessid, 'wyz_business_email2', true ),
														'Address'  => get_post_meta( $businessid, 'wyz_business_bldg', true).', '.get_post_meta( $businessid, 'wyz_business_street', true).', '.get_post_meta( $businessid, 'wyz_business_city', true).', '.get_post_meta( $businessid, 'wyz_business_country', true).', '.get_post_meta( $businessid, 'wyz_business_zipcode', true)
														);
		$business_profile_data['social_link']          = array(
														'facebook' => get_post_meta( $businessid, 'wyz_business_facebook', true),
														'twitter'  => get_post_meta( $businessid, 'wyz_business_twitter', true),
														'gplus'    => get_post_meta( $businessid, 'wyz_business_google_plus', true),
														'linkedin' => get_post_meta( $businessid, 'wyz_business_linkedin', true),
														'youtube' => get_post_meta( $businessid, 'wyz_business_youtube', true),
														'instagram' => get_post_meta( $businessid, 'wyz_business_instagram', true),
														'flicker' => get_post_meta( $businessid, 'wyz_business_flicker', true),
														'pinterest' => get_post_meta( $businessid, 'wyz_business_pinterest', true)
														);
		$business_profile_data['rating']			   = $rating;
		$business_profile_data['tags']                 = str_replace('”',',',str_replace('“','',strip_tags(get_the_term_list( $businessid, 'wyz_business_tag') )));

		return $business_profile_data;
    }

    public function get_business_meta( $req ){

    	$business_id = $req->get_param('business_id');

    	$business = get_post( $business_id, ARRAY_A );

    	if( !$business_id || !$business ) {
    		return $this->error('not_found');
    	}
    	// return $this->is_user_logged_in;
    	if( is_array( $business ) && $business['post_status'] != 'publish'  ){
    		return $this->error('bad_request');
    	}

    	if( $req->get_param('metakey') ){
    		return get_post_meta( $business_id, $req->get_param('metakey'), true );
    	}

		return get_post_meta( $business_id );
    }

    private function error($code = '', $message ='', array $data = array() ){

     	$_defaults = array(
            'bad_request' => array(
                'code'      => 'bad_request',
                'message'   => __( 'Bad Request' ),
                'data'      => array( 'status' => 400 )
            ),
            'unauthorized' => array(
                'code'      => 'unauthorized',
                'message'   => __('Unauthorized'),
                'data'      => array('status' => 401)
            ),
            'forbidden' => array(
                'code'      => 'forbidden',
                'message'   => __('Forbidden'),
                'data'      => array('status' => 403)
            ),
            'not_found' => array(
                'code'      => 'not_found',
                'message'   => __( 'Not Found' ),
                'data'      => array( 'status' => 404 )
            ),

        );

        if( $_defaults[$code] ){
            if( !empty( $message ) ){
                $_defaults[$code]['message'] = $message;
            }
            if( !empty( $data ) ){
                $_defaults[$code]['data'] = $data;
            }

            extract( $_defaults[$code] );
            return new WP_Error( $code, $message, $data );
        }
        else{
        	return new WP_Error( $code, $message, $data );
        }
    }
}
