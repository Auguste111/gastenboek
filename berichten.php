<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>

<body>
    <h1>Gastenboek</h1>

    <div class="chat">
        <?php
        $json_data = file_get_contents("berichten.json");
        $data = json_decode($json_data, true);
        $htmlString = "";

        foreach ($data as $bericht) {

            $photoHtml = isset($bericht['fileToUpload']) ? "<img src='{$bericht['fileToUpload']}' onerror='this.style.display=\"none\"'>" : "";
            $htmlString .=
                "
        <section class=\"bericht-section\">
            <h1>{$bericht['name']}</h1>
            <h2>{$bericht['message']}<h2>
            {$photoHtml}
            <h3>{$bericht['timestamp']}</h3>
        </section>
        ";

            // Controleren of er een afbeelding is toegevoegd aan het bericht


            $htmlString .= "</section>";
        }

        echo $htmlString;
        ?>
            <a class="scroll-to-bottom" href="index.php">+</a>
    </div>
</body>
</html>