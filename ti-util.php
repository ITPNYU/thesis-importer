<?php

function ti_format_content($s) {
  $thesis_content = '<h2>' . $s['preferred_name'] . "</h2>\n" 
    . $s['thesis']['elevator_pitch'];
  if (isset($s['thesis']['url'])) {
    $thesis_content .= $s['thesis']['url'] . "\n";
  }
  $thesis_keys = array(
    'image',
    'description',
    'research_process',
    'personal_statement',
    'design_process',
    'production_process',
    'user_testing',
    'feedback'
  );
  foreach ($thesis_keys as $key) {
    if (isset($s['thesis'][$key])) {
      $thesis_content .= '<h3>' . ucfirst(preg_replace('_', ' ', $key)) . "</h3/n>"
        . $s['thesis'][$key];
    } 
  }
  return $thesis_content;
}

function ti_post($s, $p) {
  $post_id = null;
  if (isset($p)) {
    $post_id = $p;
    
  }
  else {
    $advisor_cat = get_category_by_slug(sanitize_title($s['advisor']));
    if ($advisor_cat == false) {
      $advisor_cat = wp_insert_category(
        array(
          'cat_name' => $s['advisor'],
          'category_nicename' => sanitize_title($s['advisor'])
        )
      );
    }

    $post_id = wp_insert_post(
      array(
        'post_title' => $s['thesis']['title'],
        'post_name' => sanitize_title($s['preferred_name']),
        'post_status' => 'publish',
        'post_content' => ti_format_content($s),
        'post_category' => array($advisor_cat->term_id),
      )
    );
  } 
  return $post_id;
}

?>
