<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch() {
  register_rest_route('university/v1', 'search', [
    'methods'             => WP_REST_SERVER::READABLE,
    'callback'            => 'searchCallback',
    'permission_callback' => '__return_true',
  ]);
}

function searchCallback($data) {
  $results = [
    'generalInfo' => [],
    'professors'  => [],
    'programs'    => [],
    'events'      => [],
    'campuses'    => []
  ];

  mainQuery($results, sanitize_text_field($data['term']));
  programRelationshipsQuery($results);

  return $results;
}

function mainQuery(array &$results, string $searchTerm) {
  $query = new WP_Query([
    'posts_per_page' => -1,
    'post_type'      => ['post', 'page', 'professor', 'program', 'event', 'campus'],
    's'              => $searchTerm
  ]);

  while ($query->have_posts()) {
    $query->the_post();

    switch (get_post_type()) {
      case 'post':
        addPostResult($results);
        break;
      case 'page':
        addPageResult($results);
        break;
      case 'professor':
        addProfessorResult($results);
        break;
      case 'program':
        addProgramResult($results);
        break;
      case 'event':
        addEventResult($results);
        break;
      case 'campus':
        addCampusResult($results);
        break;
    }
  }

  return;
}

function programRelationshipsQuery(array &$results) {
  if (empty($results['programs'])) {
    return;
  }
  $meta_query = ['relation' => 'or'];
  foreach ($results['programs'] as $item) {
    array_push($meta_query, [
      'key'     => 'related_programs',
      'compare' => 'like',
      'value'   => $item['id']
    ]);
  }

  $query = new WP_Query([
    'posts_per_page' => -1,
    'post_type'      => ['professor', 'event', 'campus'],
    'meta_query'     => $meta_query
  ]);

  while ($query->have_posts()) {
    $query->the_post();

    switch (get_post_type()) {
      case 'professor':
        addProfessorResult($results);
        break;
      case 'event':
        addEventResult($results);
        break;
      case 'campus':
        addCampusResult($results);
        break;
    }
  }

  return;
}

function addPostResult(array &$results) {
  $post_data = [
    'id'          => get_the_ID(),
    'title'       => get_the_title(),
    'link'        => get_the_permalink(),
    'type'        => get_post_type(),
    'author_name' => get_the_author()
  ];

  array_push($results['generalInfo'], $post_data);
  return;
}

function addPageResult(array &$results) {
  $page_data = [
    'id'    => get_the_ID(),
    'title' => get_the_title(),
    'link'  => get_the_permalink()
  ];

  array_push($results['generalInfo'], $page_data);
  return;
}

function addProfessorResult(array &$results) {
  $professor_data = [
    'id'            => get_the_ID(),
    'title'         => get_the_title(),
    'link'          => get_the_permalink(),
    'thumbnail_url' => get_the_post_thumbnail_url(0, 'professorLandscape')
  ];

  if (!in_array($professor_data, $results['professors'])) {
    array_push($results['professors'], $professor_data);
  }
  return;
}

function addProgramResult(array &$results) {
  $program_data = [
    'id'    => get_the_ID(),
    'title' => get_the_title(),
    'link'  => get_the_permalink()
  ];

  array_push($results['programs'], $program_data);
  return;
}

function addEventResult(array &$results) {
  $date = new DateTime(get_field('event_date'));

  $event_data = [
    'id'          => get_the_ID(),
    'title'       => get_the_title(),
    'link'        => get_the_permalink(),
    'month'       => $date->format('M'),
    'day'         => $date->format('d'),
    'description' => has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 18)
  ];

  if (!in_array($event_data, $results['events'])) {
    array_push($results['events'], $event_data);
  }
  return;
}

function addCampusResult(array &$results) {
  $campus_data = [
    'id'    => get_the_ID(),
    'title' => get_the_title(),
    'link'  => get_the_permalink()
  ];

  if (!in_array($campus_data, $results['campuses'])) {
    array_push($results['campuses'], $campus_data);
  }
  return;
}
