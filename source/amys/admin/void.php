<?php
// php needs a timezone set otherwise it freaks
date_default_timezone_set("Europe/London");

// The database wrapper
require_once ('../inc/db/MysqliDb.php');

// environment settings
require_once ('../inc/env_set.php');

// COnnect to the DB
$db = new MysqliDb ($db_location, $db_user, $db_pass, $db_data);

$id = $_GET['id'];
$this_void_date = date('Y-m-d H:i:s');

if ( isset($id) && is_numeric($id) && strlen($id) < 5 ) {
  // If the id is set and a number and small length

  // Update its record with a voided date.
  $data = Array (
    'void_date' => $this_void_date,
  );
  $db->where ('id', $id);
  if ($db->update ('awards', $data)) {
    //echo $db->count . ' records were updated';
    // Great success!
    header("Location: index.php?void=success");
  } else {
    echo 'update failed: ' . $db->getLastError();  
  }

} else {
  // Throw a wobbly.
  header("Location: index.php?void=fail");
}
?>