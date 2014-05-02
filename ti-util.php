<?php

function ti_format_content($s) {
  $thesis_content = '<h2><em>' . $s['preferred_name'] . "</em></h2>\n" 
    . $s['thesis']['elevator_pitch'];
  if (isset($s['thesis']['link'])) {
    $thesis_content .= $s['thesis']['link'] . "\n";
  }
  if (isset($s['thesis']['image']) 
    && filter_var($s['thesis']['image'], FILTER_VALIDATE_URL)
    && !(preg_match('/\.pdf$/i', $s['thesis']['image']))) {
    $thesis_content .= '<img src="' . $s['thesis']['image'] . '" width="80%" />';
  }
  if (isset($s['thesis']['description'])) {
    $thesis_content .= "<h3>Description</h3>\n" . $s['thesis']['description'];
  }
  return $thesis_content;
}

function ti_post($s, $p) {
  $post_id = null;
  $advisor_cat = get_category_by_slug(sanitize_title($s['advisor']));
  if (isset($p)) {
    $post_id = wp_update_post(
      array(
        'ID' => $p->ID,
        'post_title' => $s['thesis']['title'],
        'post_status' => 'publish',
        'post_content' => ti_format_content($s),
        'post_category' => array($advisor_cat->term_id)
      )
    );
  }
  else {
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
  update_post_meta($post_id, 'student', $s['preferred_name']);
  return $post_id;
}

?>
