<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_rekapan";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hari = $conn->real_escape_string($_POST['hari']);
    $dosen = $conn->real_escape_string($_POST['dosen']);
    $mataKuliah = $conn->real_escape_string($_POST['mataKuliah']);
    $tugas = $conn->real_escape_string($_POST['tugas']);
    $deadline = $conn->real_escape_string($_POST['deadline']);
    $status = $conn->real_escape_string($_POST['status']);

    // Insert data into the tasks table
    $sql = $conn->prepare("INSERT INTO tasks (hari, dosen, mata_kuliah, tugas, deadline, status) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->bind_param("ssssss", $hari, $dosen, $mataKuliah, $tugas, $deadline, $status);

    if ($sql->execute()) {
        echo "New task added successfully!";
    } else {
        echo "Error: " . $sql->error;
    }

    // Close prepared statement
    $sql->close();
}

// Close connection
$conn->close();

// Redirect back to the form page
header("Location: index.php");
exit;
