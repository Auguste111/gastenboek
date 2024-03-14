<!-- credentials -->
<?php

// Database configuratie
$host = "klas4s23.mid-ica.nl"; 
$username = "588492@klas4s23.mid-ica.nl"; 
$password = "dgDYbJH6"; 
$database = "klas4s23_588492"; 

// Verbinding maken met de database
$conn = new mysqli($host, $username, $password, $database);

// Controleren op fouten tijdens het verbinden
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
