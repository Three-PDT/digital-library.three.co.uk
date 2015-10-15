<?php
// if we're on local/www set DB string differently
//echo $_SERVER['HTTP_HOST'];

$subdomain = strpos( $_SERVER['HTTP_HOST'], 'culture.three-digital.co.uk' );

if( $subdomain === false ){
  $env = 'local';
} else {
  $env = 'live';
}

switch ( $env ) {
  case 'local':
    $db_location = '127.0.0.1:3307';
    $db_user = 'root'; 
    $db_pass = 'pa55word';
    $db_data = 'the_amys';
    break;

  case 'live':
    $db_location = 'db590462216.db.1and1.com'; // don't need the port here.
    $db_user = 'dbo590462216'; 
    $db_pass = 'yad2jaJ9oj7';
    $db_data = 'db590462216';  
    break;
  
  default:
    $db_location = '';
    $db_user = ''; 
    $db_pass = '';
    $db_data = '';
    break;
}

?>