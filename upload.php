<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controleer of er minder dan een minuut is verstreken sinds de laatste verzending
    if (!isset($_SESSION['last_submit_time']) || (time() - $_SESSION['last_submit_time']) > 60) {
        // Bestandsinformatie ophalen
        $naam = htmlspecialchars($_POST["name"]);
        $bericht = htmlspecialchars($_POST["message"]);
        $timestamp = date("d-m-Y H:i");

        // check if file is uploaded set to null if not
        $file = isset($_FILES["fileToUpload"]) ? $_FILES["fileToUpload"] : null;

        // if name is longer than 50 characters error
        if (strlen($naam) > 50) {
            handleError("nameTooLong");
        } else if (strlen($bericht) > 200) {
            handleError("messageTooLong");
        } else {
            HandleUpload($naam, $bericht, $file, $timestamp);
        }
    } else {
        handleError("Je moet 1 minuut wachten voordat je een nieuw bericht kunt plaatsen.");
    }
}

function handleError($errorType)
{

    $response = array(
        "success" => "false",
        "status" => "error",
        "error" => $errorType
    );

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

function HandleUpload($naam, $bericht, $file, $timestamp)
{

    $berichtfile = "berichten.json";
    $target_dir = "uploads/";

    if ($file != null && $file["error"] != 4) {
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if (!$check) {
            handleError("notAnImage");
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            handleError("fileAlreadyExists");
        }

        // Check file size
        if ($file["size"] > 500000) {
            handleError("fileTooLarge");
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            handleError("fileTypeNotAllowed");
        }

        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            handleError("uhh");
        }
    }

    // Bestaande berichten ophalen en nieuwe berichtgegevens toevoegen
    $data = json_decode(file_get_contents($berichtfile), true);

    // Berichtgegevens opslaan in een array
    $berichtData = [
        "name" => $naam,
        "message" => $bericht,
        "fileToUpload" => $file,
        "timestamp" => $timestamp,
    ];

    // add new element to the array
    $data[] = $berichtData;

    // encode the array to json and save it to the file
    $json_data = json_encode($data, JSON_PRETTY_PRINT);

    // Bijgewerkte berichtgegevens opslaan in JSON-bestand
    file_put_contents($berichtfile, $json_data);

    // Update de tijd van de laatste verzending
    $_SESSION['last_submit_time'] = time();

    // Redirect de gebruiker naar het gastenboek nadat de verzending succesvol is
    header("Location: index.php");
    exit();
}
?>
