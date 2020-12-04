<?php

require get_theme_file_path( 'includes/like-route.php' );
require get_theme_file_path( 'includes/search-route.php' );

function university_files() {
	wp_enqueue_style( 'custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i', array(), '1.0' );
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), '1.0' );

	wp_enqueue_script( 'googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyAa-LBI2QMDy5lZsE6qhwiXOzIQyECoPUo', null, '1.0', true );

	wp_enqueue_script( 'main-university-js', get_theme_file_uri( '/build/index.js' ), null, '1.0', true );
	wp_enqueue_style( 'theme-meta-data', get_stylesheet_uri(), array(), '1.0' );
	wp_enqueue_style( 'index', get_theme_file_uri( '/build/index.css' ), array(), '1.0' );
	wp_enqueue_style( 'style-index', get_theme_file_uri( '/build/style-index.css' ), array(), '1.0' );

	wp_localize_script(
		'main-university-js',
		'universityData',
		array(
			'root_url' => get_site_url(),
			'nonce'    => wp_create_nonce( 'wp_rest' ),
		)
	);
}

add_action( 'wp_enqueue_scripts', 'university_files' );


function university_features() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'professorLandscape', 400, 260, true );
	add_image_size( 'professorPortrait', 480, 650, true );
	add_image_size( 'pageBanner', 1500, 350, true );

	register_nav_menu( 'headerMainNavigation', 'Main Header Navigation' );
	register_nav_menu( 'footerLocationOne', 'Footer Location One' );
	register_nav_menu( 'footerLocationTwo', 'Footer Location Two' );
}

add_action( 'after_setup_theme', 'university_features' );


function university_adjust_queries( $query ) {
	if ( ! is_admin() && is_post_type_archive( 'event' ) && $query->is_main_query() ) {
		$query->set( 'meta_key', 'event_date' );
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'order', 'ASC' );
		$query->set(
			'meta_query',
			array(
				array(
					'key'     => 'event_date',
					'compare' => '>=',
					'value'   => gmdate( 'Ymd' ),
					'type'    => 'numeric',
				),
			)
		);
	}

	if ( ! is_admin() && is_post_type_archive( 'program' ) && $query->is_main_query() ) {
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );
		$query->set( 'posts_per_page', -1 );
	}
}

add_action( 'pre_get_posts', 'university_adjust_queries' );


function university_map_key( $api ) {
	$api['key'] = 'AIzaSyAa-LBI2QMDy5lZsE6qhwiXOzIQyECoPUo';

	return $api;
}

add_filter( 'acf/fields/google_map/api', 'university_map_key' );

function university_custom_rest() {
	register_rest_field(
		'post',
		'author_name',
		array(
			'get_callback' => function () {
				return get_the_author();
			},
		)
	);
	register_rest_field(
		'professor',
		'page_banner_subtitle',
		array(
			'get_callback' => function () {
				return get_field( 'page_banner_subtitle' );
			},
		)
	);
	register_rest_field(
		'note',
		'user_note_count',
		array(
			'get_callback' => function () {
				return count_user_posts( get_current_user_id(), 'note' );
			},
		)
	);
}

add_action( 'rest_api_init', 'university_custom_rest' );


//https://gist.github.com/gerbenvandijk/5253921
//doesn't quite work
function add_current_nav_class( $classes, $item ) {

	// Getting the current post details
	global $post;

	// Get post ID, if nothing found set to NULL
	$id = ( isset( $post->ID ) ? get_the_ID() : null );

	// Checking if post ID exist...
	if ( isset( $id ) ) {

		// Getting the post type of the current post
		$current_post_type = get_post_type_object( get_post_type( $post->ID ) );

		// Getting the rewrite slug containing the post type's ancestors
		$ancestor_slug = $current_post_type->rewrite ? $current_post_type->rewrite['slug'] : '';

		// Split the slug into an array of ancestors and then slice off the direct parent.
		$ancestors = explode( '/', $ancestor_slug );
		$parent    = array_pop( $ancestors );

		// Getting the URL of the menu item
		$menu_slug = strtolower( trim( $item->url ) );

		// Remove domain from menu slug
		$menu_slug = str_replace( $_SERVER['SERVER_NAME'], '', $menu_slug );

		// If the menu item URL contains the post type's parent
		if ( ! empty( $menu_slug ) && ! empty( $parent ) && strpos( $menu_slug, $parent ) !== false ) {
			$classes[] = 'current-menu-item';
		}

		// If the menu item URL contains any of the post type's ancestors
		foreach ( $ancestors as $ancestor ) {
			if ( ! empty( $menu_slug ) && ! empty( $ancestor ) && strpos( $menu_slug, $ancestor ) !== false ) {
				$classes[] = 'current-page-ancestor';
			}
		}
	}

	// Return the corrected set of classes to be added to the menu item
	return $classes;

}

add_action( 'nav_menu_css_class', 'add_current_nav_class', 10, 2 );

// https://core.trac.wordpress.org/ticket/22430
// https://www.kevinleary.net/wordpress-ob_end_flush-error-fix/
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
add_action(
	'shutdown',
	function () {
		while ( @ob_end_flush() );
	}
);

// Redirect subscriber accounts out of admin and onto homepage
add_action( 'admin_init', 'redirect_subscribers' );

function redirect_subscribers() {
	$user = wp_get_current_user();
	if ( count( $user->roles ) === 1 && $user->roles[0] === 'subscriber' ) {
		wp_safe_redirect( site_url( '/' ) );
		exit;
	}
}

add_action( 'wp_loaded', 'hide_admin_bar_for_subscribers' );

function hide_admin_bar_for_subscribers() {
	$user = wp_get_current_user();
	if ( count( $user->roles ) === 1 && $user->roles[0] === 'subscriber' ) {
		show_admin_bar( false );
	}
}

// Customize login screen
add_filter(
	'login_headerurl',
	function () {
		return esc_url( site_url( '/' ) );
	}
);

add_action(
	'login_enqueue_scripts',
	function () {
		wp_enqueue_style( 'index', get_theme_file_uri( '/build/index.css' ), array(), '1.0' );
		wp_enqueue_style( 'style-index', get_theme_file_uri( '/build/style-index.css' ), array(), '1.0' );
	}
);

add_filter(
	'login_headertext',
	function () {
		return get_bloginfo( 'name' );
	}
);

add_filter(
	'wp_insert_post_data',
	function ( $data ) {

		// limit number of Notes each user can create
		if ( $data['post_type'] === 'note' && count_user_posts( get_current_user_id(), 'note' ) > 4 && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			$error = array( 'msg' => sanitize_text_field( 'You have reached your note limit.' ) );
			wp_send_json_error( $error, 400 );
		}

		// dont allow HTML tags
		if ( $data['post_type'] === 'note' ) {
			$data['post_title']   = sanitize_text_field( $data['post_title'] );
			$data['post_content'] = sanitize_textarea_field( $data['post_content'] );
		}

		// Force note posts to be private
		if ( $data['post_type'] === 'note' && $data['post_status'] !== 'trash' ) {
			$data['post_status'] = 'private';
		}
		return $data;
	}
);
