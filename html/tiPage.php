<h2>Thesis Importer</h2>
<?php 
$export = '';
if (get_option('ti_export_url')) {
  echo 'importing from ' . get_option('ti_export_url') . '... ';
  $export = file_get_contents(get_option('ti_export_url'));
  echo '<br />';
  echo $export;
}
else {
  echo "ti_export_url not set";
}

?>