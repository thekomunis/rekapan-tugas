<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "db_rekapan");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "DELETE FROM tasks WHERE id = $id";
$conn->query($sql);
$conn->close();
header("Location: index.php");
