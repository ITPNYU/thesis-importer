<?php

function ti_format_content($s) {
  $thesis_content = '<h2>' . $s['preferred_name'] . "</h2>\n" 
    . $s['thesis']['elevator_pitch'];
  if (isset($s['thesis']['link'])) {
    $thesis_content .= $s['thesis']['link'] . "\n";
  }
  $thesis_keys = array(
    'image' => 'Image',
    'description' => 'Description',
    'research_plan' => 'Research Process',
    'reason' => 'Personal Statement',
    'design_process' => 'Design Process',
    'production_process' => 'Production Process',
    'user_testing' => 'User Testing',
    'feedback' => 'Feedback',
    'conclusions' => 'Conclusions'
  );
  foreach ($thesis_keys as $key) {
    if (isset($s['thesis'][$key]) && ($s['thesis'][$key] != '')) {
      $h_key = $key;
      $thesis_content .= '<h3>' . $thesis_keys[$h_key] . "</h3>\n"
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
