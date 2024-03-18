<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastenboek</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section id="one">
        <h1>Gastenboek</h1>
        <!-- <form action="upload.php" method="post" enctype="multipart/form-data"> -->
            <input type="text" name="name" id= "name" placeholder="Type je naam">
            <textarea name="message" id="message" rows="5" placeholder="Type je bericht"></textarea>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <button id="submitBtn"> verstuur gegevens</button>     
            <!-- </form> -->
        </section>
    </body>
    <script src="script.js"></script>
</html>
