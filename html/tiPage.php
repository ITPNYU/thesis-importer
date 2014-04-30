<h2>Thesis Importer</h2>
<?php 
$export_json = '';
$export = array();
if (get_option('ti_export_url')) {
  echo 'Importing from ' . get_option('ti_export_url') . '... ';
  $export_json = file_get_contents(get_option('ti_export_url'));
  $export = json_decode($export_json, TRUE);
  if (count($export) > 0) {
    echo ' retrieved ' . count($export) . ' theses.';
/*    echo "<ul>\n";
    foreach ($export as $t) {
      echo '<li>' . $t['preferred_name'] . ': ' . $t['thesis']['title'] . "</li>\n";
    }
    echo "</ul>\n";
*/
    foreach ($export as $student) {
      $post_id = ti_post($student, null);
      if ( is_wp_error($post_id) ) {
        echo $post_id->get_error_message();
      }
      else {
        echo 'created post ID ' . $post_id . "<br />\n";
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


