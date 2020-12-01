<?php


function university_post_types()
{
  // Event Post Type
  register_post_type(
    'event',
    [
      'public'          => true,
      'menu_icon'       => 'dashicons-calendar',
      'labels'          => [
        'name'          => 'Events',
        'add_new_item'  => 'Add New Event',
        'edit_item'     => 'Edit Event',
        'all_items'     => 'All Events',
        'singular_name' => 'Event',
      ],
      'has_archive'     => true,
      'rewrite'         => [ 'slug' => 'events' ],
      'supports'        => [
        'title',
        'editor',
        'excerpt',
      ],
      'show_in_rest'    => true,
      'capability_type' => 'event',
      'map_meta_cap'    => true,
    ]
  );

  // Program Post Type
  register_post_type(
    'program',
    [
      'public'       => true,
      'menu_icon'    => 'dashicons-awards',
      'labels'       => [
        'name'          => 'Programs',
        'add_new_item'  => 'Add New Program',
        'edit_item'     => 'Edit Program',
        'all_items'     => 'All Programs',
        'singular_name' => 'Program',
      ],
      'has_archive'  => true,
      'rewrite'      => [ 'slug' => 'programs' ],
      'supports'     => [ 'title' ],
      'show_in_rest' => true,
    ]
  );

  // Professor Post Type
  register_post_type(
    'professor',
    [
      'public'       => true,
      'menu_icon'    => 'dashicons-welcome-learn-more',
      'labels'       => [
        'name'          => 'Professors',
        'add_new_item'  => 'Add New Professor',
        'edit_item'     => 'Edit Professor',
        'all_items'     => 'All Professors',
        'singular_name' => 'Professor',
      ],
      'supports'     => [
        'title',
        'editor',
        'thumbnail',
      ],
      'show_in_rest' => true,
    ]
  );

  // Campus Post Type
  register_post_type(
    'campus',
    [
      'public'          => true,
      'menu_icon'       => 'dashicons-location-alt',
      'labels'          => [
        'name'          => 'Campuses',
        'add_new_item'  => 'Add New Campus',
        'edit_item'     => 'Edit Campus',
        'all_items'     => 'All Campuses',
        'singular_name' => 'Campus',
      ],
      'has_archive'     => true,
      'rewrite'         => [ 'slug' => 'campuses' ],
      'supports'        => [
        'title',
        'editor',
        'excerpt',
      ],
      'show_in_rest'    => true,
      'capability_type' => 'campus',
      'map_meta_cap'    => true,
    ]
  );

  // Note Post Type
  register_post_type(
    'note',
    [
      'public'          => false,
      'show_ui'         => true,
      'menu_icon'       => 'dashicons-welcome-write-blog',
      'labels'          => [
        'name'          => 'Notes',
        'add_new_item'  => 'Add New Note',
        'edit_item'     => 'Edit Note',
        'all_items'     => 'All Notes',
        'singular_name' => 'Note',
      ],
      'supports'        => [
        'title',
        'editor',
      ],
      'show_in_rest'    => true,
      'capability_type' => 'note',
      'map_meta_cap'    => true,
    ]
  );

}//end university_post_types()


add_action('init', 'university_post_types');
