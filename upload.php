<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Bestandsinformatie ophalen
    $naam = htmlspecialchars($_POST["name"]);
    $bericht = htmlspecialchars($_POST["message"]);
    $timestamp = date("d-m-Y H:i");

    // set initial file to null in case no file is uploaded
    $file = null;

    // Check if a file has been uploaded
    if (isset($_FILES['fileToUpload'])) {
       $file = HandleImageUpload();
    }

    // Berichtgegevens opslaan in een array
    $berichtData = [
        "name" => $naam, 
        "message" => $bericht,
        "fileToUpload" => $file,
        "timestamp" => $timestamp,
    ];

    // Bestaande berichten ophalen en nieuwe berichtgegevens toevoegen
    $data = json_decode(file_get_contents("berichten.json"), true);

    // add new element to the array
    $data[] = $berichtData;

    // encode the array to json and save it to the file
    $json_data = json_encode($data, JSON_PRETTY_PRINT);

    // Bijgewerkte berichtgegevens opslaan in JSON-bestand
    file_put_contents("berichten.json", $json_data);
    
    $response = array(
      "success" => "true",
      "status" => "success"	
    );

    header('Content-Type: application/json');
    // echo json_encode($response);
    header('Location: berichten.php');
}

function handleError($errorType){

  $response = array(
    "success" => "false",
    "status" => "error",
    "error" => $errorType
  );

  header('Content-Type: application/json');
  echo json_encode($response);
  exit();
}

function HandleImageUpload()
{

  // folder for uploading
  $target_dir = "uploads/";

  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
  // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if(!$check ) {
    handleError("notAnImage");
  }
  
  // Check if file already exists
  if (file_exists($target_file)) {
    handleError("fileAlreadyExists");
  }
  
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    handleError("fileTooLarge");
  }
  
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    handleError("fileTypeNotAllowed");
  }
  
  if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    handleError("uhh");
  }

  return $target_file;

header('Location: berichten.php');
}
