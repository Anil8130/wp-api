<?php
namespace Api\Authentication;

class Authentication{

    protected $wp_json_basic_auth_error = false;

    public function __construct( $authenticate = true ){
        /* API Authentication Error */
        add_filter( 'rest_authentication_errors', array($this, 'json_basic_auth_error') );

        /* WP JSON Basic Auth Handler */
        add_filter( 'determine_current_user', array($this, 'json_basic_auth_handler'), 20 );
    }

    public function json_basic_auth_handler( $user ) {
        $this->wp_json_basic_auth_error = null ;

        // Don't authenticate twice
    	if ( ! empty( $user ) ) {
    		return $user;
    	}

    	// Check that we're trying to authenticate
    	if ( !isset( $_SERVER['PHP_AUTH_USER'] ) ) {
    		return $user;
    	}

    	$username = $_SERVER['PHP_AUTH_USER'];
    	$password = $_SERVER['PHP_AUTH_PW'];

    	/**
    	 * In multi-site, wp_authenticate_spam_check filter is run on authentication. This filter calls
    	 * get_currentuserinfo which in turn calls the determine_current_user filter. This leads to infinite
    	 * recursion and a stack overflow unless the current function is removed from the determine_current_user
    	 * filter during authentication.
    	 */
    	remove_filter( 'determine_current_user', 'json_basic_auth_handler', 20 );

    	$user = wp_authenticate( $username, $password );

    	add_filter( 'determine_current_user', 'json_basic_auth_handler', 20 );

    	if ( is_wp_error( $user ) ) {
    		$this->wp_json_basic_auth_error = $user;
    		return null;
    	}

    	$this->wp_json_basic_auth_error = true;

    	return $user->ID;
    }

    public function json_basic_auth_error( $error ) {
        // Pass through other errors
        if (  $this->wp_json_basic_auth_error  ) {
            return new WP_Error(
                'rest_authentication_error',
                __( 'You are not authorized for this request.' ),
                array( 'status' => 401, 'authentication' => $this->wp_json_basic_auth_error )
            );
        }

        return $error;
    }
}
