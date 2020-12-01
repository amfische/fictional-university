<?php 

add_action( 'rest_api_init', 'universityLikeRoutes' );

function universityLikeRoutes() {
	register_rest_route( 'university/v1', 'manage-like', [
		'methods' => 'post',
		'callback' => 'createLike',
		'permission_callback' => '__return_true',
	]);

	register_rest_route( 'university/v1', 'manage-like', [
		'methods' => 'delete',
		'callback' => 'deleteLike',
		'permission_callback' => '__return_true',
	]);
}

function createLike($data) {
	if (!is_user_logged_in()) {
		return wp_send_json_error(['msg' => 'You must be logged in to like a professor.'], 403);
	}

	if (get_post_status($data['professorId']) === false) {
		return wp_send_json_error(['msg' => 'Professor does not exist.'], 404);
	}

	$likes = get_field('user_likes', $data['professorId']) ?? [];
	if (in_array(get_current_user_id(), $likes)) {
		return wp_send_json_error(['msg' => 'You have already liked this professor.'], 422);
	}

	$likes[] = get_current_user_id();
	update_field('user_likes', $likes, $data['professorId']);
	return true;
}

function deleteLike($data) {
	if (!is_user_logged_in()) {
		return wp_send_json_error(['msg' => 'You must be logged in to do that.'], 403);
	}

	$likes = get_field('user_likes', $data['professorId']) ?? [];
	if (in_array(get_current_user_id(), $likes)) {
		$likes = array_values(array_filter($likes, fn ($id) => $id !== get_current_user_id()));
		update_field('user_likes', $likes, $data['professorId']);
		return true;
	}

	return wp_send_json_error(['msg' => 'Permission Denied.'], 422);
}