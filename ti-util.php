<?php

function ti_format_content($s) {
  $thesis_content = '';
  $thesis_keys = array('elevator_pitch', 'description');
  foreach ($thesis_keys as $key) {
    if (isset($s['thesis'][$key])) {
      $thesis_content = $thesis_content . $s['thesis'][$key];
    } 
  }
  return $thesis_content;
}

function ti_post($s, $p) {
  $post_id = null;
  if (isset($p)) {
    
  }
  else {
    $post_id = wp_insert_post( array(
      'post_title' => $s['thesis']['title'],
      'post_name' => sanitize_title($s['preferred_name'] . '-' . $s['thesis']['title']),
      'post_status' => 'publish',
      'post_content' => ti_format_content($s) #,
      #'post_category' => array(),
    ) );
  } 
  return $post_id;
}

?>
