<?php

add_action( 'rest_api_init', 'university_like_routes' );

function university_like_routes() {
	register_rest_route(
		'university/v1',
		'manage-like',
		array(
			'methods'             => 'post',
			'callback'            => 'create_like',
			'permission_callback' => '__return_true',
		)
	);

	register_rest_route(
		'university/v1',
		'manage-like',
		array(
			'methods'             => 'delete',
			'callback'            => 'delete_like',
			'permission_callback' => '__return_true',
		)
	);
}

function create_like( $data ) {
	if ( ! is_user_logged_in() ) {
		return wp_send_json_error( array( 'msg' => 'You must be logged in to like a professor.' ), 403 );
	}

	if ( get_post_status( $data['professorId'] ) === false ) {
		return wp_send_json_error( array( 'msg' => 'Professor does not exist.' ), 404 );
	}

	$likes = get_field( 'user_likes', $data['professorId'] ) ?? array();
	if ( in_array( get_current_user_id(), $likes ) ) {
		return wp_send_json_error( array( 'msg' => 'You have already liked this professor.' ), 422 );
	}

	$likes[] = get_current_user_id();
	update_field( 'user_likes', $likes, $data['professorId'] );
	return true;
}

function delete_like( $data ) {
	if ( ! is_user_logged_in() ) {
		return wp_send_json_error( array( 'msg' => 'You must be logged in to do that.' ), 403 );
	}

	$likes = get_field( 'user_likes', $data['professorId'] ) ?? array();
	if ( in_array( get_current_user_id(), $likes, true ) ) {
		$likes = array_filter(
			$likes,
			function( $id ) {
				get_current_user_id() !== $id;
			}
		);
		$likes = array_values( $likes );
		update_field( 'user_likes', $likes, $data['professorId'] );
		return true;
	}

	return wp_send_json_error( array( 'msg' => 'Permission Denied.' ), 422 );
}
