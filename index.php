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
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
    $( function() {
        $( "#datepicker" ).datepicker();
    } );
    </script>

    <title>Document</title>
</head>
<body>
    <div id=header>
        <img id=logo src="logo-upscaled.png" alt="Girl in a jacket" width="80px" height="80px">
        F.I.S.H - Fish Identification Search History
        <br>
        <span class="bold">Admin Portal</span>
    </div>

    <form method="post">
    <p id='date'>Date: <input type="text" id="datepicker" name="datepicker"></p>
    <input name="submit" type="submit" value="Submit">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $selected_date = $_POST['datepicker'];
        $utc_date = new DateTime($selected_date, new DateTimeZone('UTC'));
        $local_date = new DateTime();
        $local_date_str = $local_date->format('Y-m-d 00:00:00');

        // Retrieve selected item information from the database
        $servername = "localhost";
        $username = "root";
        $password = "Greenlantern#4";
        $dbname = "testfish";
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT * FROM fishdata WHERE lastCaught BETWEEN '{$utc_date->format('Y-m-d 00:00:00')}' AND '{$local_date_str}'";

        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            echo "<form action='process.php' method='post'>
                  <select name='catch_id' size = '3'>";

            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<option value='".$row["catch_id"]."'>
                        Catch ID: ".$row["catch_id"]." | PIT Tag: ".$row["pit"]." | HEX: ".$row["hex"]." | Date Last Caught: ".$row["lastCaught"]." | Fish Species: ".$row["species"]." | Fish Length: ".$row["length"]." | River Mile Caught: ".$row["riverMile"]."
                      </option>";
            }
            echo "</select>
                  <br>
                  <input type='submit' name='edit' value='Edit'>
                  <input type='submit' name='delete' value='Delete'>
                  </form>";
                  
          } else {
            echo "0 results";
          }
          $conn->close();

    }
    ?>
</body>
</html>