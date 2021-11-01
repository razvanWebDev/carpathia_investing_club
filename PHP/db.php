<?php
$site_key = '6LfN8zAcAAAAAHttXGnld2PxkLVn2uXG9x80cv8Y';
$secret_key = '6LfN8zAcAAAAAOxPtyCvnWqW5MMgHdGE8HrUx0_z';

  $server = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'carpathia_investing_club'; 

  // $server = 'server-0306.whmpanels.com';
  // $username = 'r90257carp_r90257carp';
  // $password = 'y0kvne[.0p*j';
  // $dbname = 'r90257carp_carpathia_investing_club';  

  $website_url = "https://carpathiainvestingclub.org";

  $connection = new mysqli($server, $username, $password, $dbname);

if ($connection-> connect_errno) {
  echo "Failed to connect to MySQL: " . $connection -> connect_error;
  exit();
}
?>