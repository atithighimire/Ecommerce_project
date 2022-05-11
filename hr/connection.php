<?php

define('DB_SERVER', 'localhost:3306');
define('DB_USER', 'ghimira1_atts');
define('DB_PASS', 'BlueGrass33$$');
define('DB_NAME', 'ghimira1_raritan_valley_ecom');
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);


if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL:" . mysqli_connect_error();
}


?>