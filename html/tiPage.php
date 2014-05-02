<h2>Thesis Importer</h2>
<?php 
$export_json = '';
$export = array();
if (get_option('ti_export_url')) {
  echo 'Importing from ' . get_option('ti_export_url') . '... ';
  $export_json = file_get_contents(get_option('ti_export_url'));
  $export = json_decode($export_json, TRUE);
  if (count($export) > 0) {
    echo ' retrieved ' . count($export) . ' theses.<br />';
/*    echo "<ul>\n";
    foreach ($export as $t) {
      echo '<li>' . $t['preferred_name'] . ': ' . $t['thesis']['title'] . "</li>\n";
    }
    echo "</ul>\n";
*/
    foreach ($export as $student) {
      $existing = get_posts(array(
        'meta_key' => 'student',
        'meta_value' => $student['preferred_name']
      ));
      if (count($existing) > 0) {
        $post_id = $existing[0];
        echo "updating ";
      }
      else {
        $post_id = null;
        echo "creating ";
      }
      $post_id = ti_post($student, $post_id);
      if ( is_wp_error($post_id) ) {
        echo $post_id->get_error_message();
      }
      else {
        echo 'post ID ' . $post_id . "<br />\n";
      }
    }
  }
  else {
    echo 'cannot read thesis export.';
  }
  echo '<br />';
}
else {
  echo "Thesis Importer export URL not set";
}
?>


