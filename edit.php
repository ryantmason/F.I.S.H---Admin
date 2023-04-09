<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Saira&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">

    <link rel="stylesheet" href="/resources/demos/style.css">

    <title>Document</title>
</head>
<body>
    <div id=header>
        <img id=logo src="logo-upscaled.png" alt="Girl in a jacket" width="80px" height="80px">
        F.I.S.H - Fish Identification Search History
        <br>
        <span class="bold">Admin Portal</span>
    </div>

    <?php
    // Create a connection to the database
    $servername = "localhost";
    $username = "root";
    $password = "Greenlantern#4";
    $dbname = "testfish";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle form submission
        $catch_id = $_POST['catch_id'];
        $species = $_POST['species'];
        $weight = $_POST['weight'];
        $length = $_POST['length'];

        // Update the selected entry in the database
        $query = "UPDATE fishdata SET species='$species', length='$length' WHERE catch_id = $catch_id";
        if ($conn->query($query) === TRUE) {
            echo "Record updated successfully";
            header("Location: index.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        // Retrieve the entry to be edited from the database using the 'id' value passed through the URL
        $catch_id = $_GET['id'];
        $query = "SELECT catch_id, pit, hex, lastCaught, species, length, riverMile FROM fishdata WHERE catch_id = $catch_id";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            // Display the form with the values from the selected entry pre-filled
            $row = $result->fetch_assoc();
            $species = $row['species'];
            $length = $row['length'];
            $pit = $row['pit'];
            $hex = $row['hex'];
            $lastCaught = $row['lastCaught'];
            $riverMile = $row['riverMile'];

            echo "<form method='post'>";
            echo "<input type='hidden' name='catch_id' value='$catch_id'>";
            echo "Species: <input type='text' name='species' value='$species'><br>";
            echo "Length: <input type='text' name='length' value='$length'><br>";
            echo "Pit: <input type='text' name='pit' value='$pit'><br>";
            echo "Hex: <input type='text' name='hex' value='$hex'><br>";
            echo "Last Caught: <input type='text' name='lastCaught' value='$lastCaught'><br>";
            echo "River Mile: <input type='text' name='riverMile' value='$riverMile'><br>";
            echo "<input type='submit' value='Save'>";
            echo "</form>";
        } else {
            echo "No matching record found";
        }
    }

    $conn->close();
    ?>
</body>
</html>
