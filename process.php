<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    if (isset($_POST['edit'])) {
        // Handle "Edit" button click
        $catch_id = $_POST['catch_id'];
        // Redirect to an edit page where you can modify the selected entry
        header("Location: edit.php?id=$catch_id");
        exit();
    } elseif (isset($_POST['delete'])) {
        // Handle "Delete" button click
        $catch_id = $_POST['catch_id'];
        // Delete the selected entry from the database
        $query = "DELETE FROM fishdata WHERE catch_id = $catch_id";
        if ($conn->query($query) === TRUE) {
            echo "Record deleted successfully";
            header("Location: index.php");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }

    $conn->close();
}
?>