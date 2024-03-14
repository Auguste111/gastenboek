<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";

    // hier willen we een error aanroepen
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";

   // hier willen we een error aanroepen
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5) {
  echo "Sorry, your file is too large.";
  $response = array(
    "success" => "true",
    "message" => "Sorry, your file is too large."	
  );
  handleError($response);
  exit();

   // hier willen we een error aanroepen
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";

   // hier willen we een error aanroepen
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Bestandsinformatie ophalen
    $naam = $_POST["naam"];
    $bericht = $_POST["bericht"];
    $timestamp = date("d-m-Y H:i");

    // Controleren of er een afbeelding is geüpload
    if ($_FILES['afbeelding']['error'] === UPLOAD_ERR_OK) {
        $afbeeldingName = $_FILES['afbeelding']['name'];
        $afbeeldingPath = 'uploads/' . $afbeeldingName; // Map instellen waarin de afbeelding wordt opgeslagen
        
        // De afbeelding verplaatsen naar de uploads map
        move_uploaded_file($_FILES['afbeelding']['tmp_name'], $afbeeldingPath);
    }

    // Berichtgegevens opslaan in een array
    $berichtData = [
        "naam" => $naam, 
        "bericht" => $bericht,
        "afbeelding" => $_FILES["fileToUpload"]["name"],
        "timestamp" => $timestamp,
    ];

    // Bestaande berichten ophalen en nieuwe berichtgegevens toevoegen
    $data = json_decode(file_get_contents("berichten.json"), true);
    $data[] = $berichtData;

    // Bijgewerkte berichtgegevens opslaan in JSON-bestand
    file_put_contents("berichten.json", 
    $json_data = json_encode($data, JSON_PRETTY_PRINT));

    $response = array(
      "success" => "true",
      "message" => "Everything went as planned."	
    );

    header('Content-Type: application/json');
    echo json_encode($response);
}



// Gebruiker doorsturen naar de berichten.php pagina
// header("Location: berichten.php");

function handleError($response){

    // echo "Er is iets fout gegaan";
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>


