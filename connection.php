<!-- credentials -->
<?php

// Database configuratie
require_once 'config.php';

// Verbinding maken met de database met PDO
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);


?>
